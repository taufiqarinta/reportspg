<?php

namespace App\Exports;

use App\Models\ReportStockSPG;
use App\Models\ReportStockSPGDetail;
use App\Models\ItemMaster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ReportStockSPGExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Debug: cek filter yang diterima
        \Log::info('Export filters:', $this->filters);
        
        // Ambil semua report berdasarkan filter
        $reportsQuery = ReportStockSPG::with(['user', 'details.itemMaster'])
            ->where('tahun', $this->filters['tahun'])
            ->where('bulan', $this->filters['bulan'])
            ->when(isset($this->filters['minggu_ke']), function($q) {
                $q->where('minggu_ke', $this->filters['minggu_ke']);
            })
            ->when(isset($this->filters['user_id']), function($q) {
                $q->where('user_id', $this->filters['user_id']);
            })
            ->orderBy('user_id', 'asc')
            ->orderBy('toko_id', 'asc')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('minggu_ke', 'asc');

        $reports = $reportsQuery->get();
        
        \Log::info('Jumlah report ditemukan: ' . $reports->count());
        
        if ($reports->isEmpty()) {
            return new Collection([]);
        }
        
        $exportData = [];
        
        // Grup data berdasarkan nama_spg, nama_toko, dan item_code
        foreach ($reports as $report) {
            // Ambil semua item yang ada di report ini
            foreach ($report->details as $detail) {
                $itemCode = $detail->item_code;
                $namaSpg = $report->user ? $report->user->name : '-';
                $namaToko = $report->nama_toko;
                $mingguKe = $report->minggu_ke;
                
                // Cari index untuk item ini (dikelompokkan berdasarkan SPG, Toko, dan Item)
                $key = $namaSpg . '_' . $namaToko . '_' . $itemCode;
                
                if (!isset($exportData[$key])) {
                    // Buat entry baru jika belum ada
                    $exportData[$key] = [
                        'nama_spg' => $namaSpg,
                        'nama_toko' => $namaToko,
                        'item_code' => $itemCode,
                        'item_name' => $detail->itemMaster ? $detail->itemMaster->item_name : $detail->nama_barang,
                        'ukuran' => $detail->itemMaster ? $detail->itemMaster->ukuran : $detail->ukuran,
                        'stock_awal_bulan' => 0,
                        'qty_masuk_minggu1' => 0,
                        'qty_masuk_minggu2' => 0,
                        'qty_masuk_minggu3' => 0,
                        'qty_masuk_minggu4' => 0,
                        'qty_masuk_minggu5' => 0,
                        'catatan_minggu1' => '',
                        'catatan_minggu2' => '',
                        'catatan_minggu3' => '',
                        'catatan_minggu4' => '',
                        'catatan_minggu5' => '',
                        'stock_minggu1' => 0,
                        'stock_minggu2' => 0,
                        'stock_minggu3' => 0,
                        'stock_minggu4' => 0,
                        'stock_minggu5' => 0,
                    ];
                }
                
                // Update data berdasarkan minggu
                $exportData[$key]['qty_masuk_minggu' . $mingguKe] = $detail->qty_masuk;
                $exportData[$key]['catatan_minggu' . $mingguKe] = $detail->catatan;
                $exportData[$key]['stock_minggu' . $mingguKe] = $detail->stock;
                
                // Jika ini minggu 1, cari stock awal bulan
                if ($mingguKe == 1) {
                    $previousMonth = $report->bulan - 1;
                    $previousYear = $report->tahun;
                    
                    if ($previousMonth == 0) {
                        $previousMonth = 12;
                        $previousYear = $report->tahun - 1;
                    }
                    
                    $lastWeekPreviousMonth = ReportStockSPG::query()
                        ->where('tahun', $previousYear)
                        ->where('bulan', $previousMonth)
                        ->where('user_id', $report->user_id)
                        ->where('toko_id', $report->toko_id)
                        ->orderBy('minggu_ke', 'desc')
                        ->first();
                        
                    if ($lastWeekPreviousMonth) {
                        $previousDetail = ReportStockSPGDetail::where('report_id', $lastWeekPreviousMonth->id)
                            ->where('item_code', $itemCode)
                            ->first();
                            
                        if ($previousDetail) {
                            $exportData[$key]['stock_awal_bulan'] = $previousDetail->stock;
                        }
                    }
                }
            }
        }
        
        // Konversi array asosiatif ke array numerik dan urutkan
        $sortedData = array_values($exportData);
        
        // Urutkan data: pertama berdasarkan nama_spg, lalu nama_toko, lalu item_code
        usort($sortedData, function($a, $b) {
            if ($a['nama_spg'] == $b['nama_spg']) {
                if ($a['nama_toko'] == $b['nama_toko']) {
                    return strcmp($a['item_code'], $b['item_code']);
                }
                return strcmp($a['nama_toko'], $b['nama_toko']);
            }
            return strcmp($a['nama_spg'], $b['nama_spg']);
        });
        
        \Log::info('Jumlah data export (setelah digabung): ' . count($sortedData));
        
        return new Collection($sortedData);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama SPG',
            'Nama Toko',
            'Kode Item',
            'Nama Barang',
            'Ukuran',
            'Stock Awal Bulan',
            'Qty Barang Masuk Minggu 1',
            'Qty Barang Masuk Minggu 2',
            'Qty Barang Masuk Minggu 3',
            'Qty Barang Masuk Minggu 4',
            'Qty Barang Masuk Minggu 5',
            'Catatan Minggu 1',
            'Catatan Minggu 2',
            'Catatan Minggu 3',
            'Catatan Minggu 4',
            'Catatan Minggu 5',
            'Stock Minggu 1',
            'Stock Minggu 2',
            'Stock Minggu 3',
            'Stock Minggu 4',
            'Stock Minggu 5'
        ];
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;
        
        return [
            $index,  // No
            $row['nama_spg'],  // Nama SPG
            $row['nama_toko'],  // Nama Toko
            $row['item_code'],  // Kode Item
            $row['item_name'],  // Nama Barang
            $row['ukuran'] ?? '-',  // Ukuran
            $row['stock_awal_bulan'],  // Stock Awal Bulan
            $row['qty_masuk_minggu1'],  // Qty Masuk Minggu 1
            $row['qty_masuk_minggu2'],  // Qty Masuk Minggu 2
            $row['qty_masuk_minggu3'],  // Qty Masuk Minggu 3
            $row['qty_masuk_minggu4'],  // Qty Masuk Minggu 4
            $row['qty_masuk_minggu5'],  // Qty Masuk Minggu 5
            $row['catatan_minggu1'] ?? '',  // Catatan Minggu 1
            $row['catatan_minggu2'] ?? '',  // Catatan Minggu 2
            $row['catatan_minggu3'] ?? '',  // Catatan Minggu 3
            $row['catatan_minggu4'] ?? '',  // Catatan Minggu 4
            $row['catatan_minggu5'] ?? '',  // Catatan Minggu 5
            $row['stock_minggu1'],  // Stock Minggu 1
            $row['stock_minggu2'],  // Stock Minggu 2
            $row['stock_minggu3'],  // Stock Minggu 3
            $row['stock_minggu4'],  // Stock Minggu 4
            $row['stock_minggu5'],  // Stock Minggu 5
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (22 kolom: A-V)
        $sheet->getStyle('A1:V1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Auto filter
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->setAutoFilter('A1:V' . $lastRow);
        }

        // Wrap text untuk kolom catatan (M-Q)
        $sheet->getStyle('M:Q')->getAlignment()->setWrapText(true);

        // Format untuk kolom angka
        // Stock Awal Bulan (G) dan Qty Masuk (H-L)
        $sheet->getStyle('G:L')->getNumberFormat()->setFormatCode('#,##0');
        
        // Stock Minggu 1-5 (R-V)
        $sheet->getStyle('R:V')->getNumberFormat()->setFormatCode('#,##0');

        // Style untuk kolom stock minggu 5 (kolom V)

        // Alternating row colors untuk readability
        for ($row = 2; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':V' . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('F8FAFC');
            }
        }

        // Set tinggi row untuk header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Center alignment untuk kolom angka
        $sheet->getStyle('G:V')->getAlignment()->setHorizontal('center');
        
        // Left alignment untuk kolom teks
        $sheet->getStyle('A:F')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('M:Q')->getAlignment()->setHorizontal('left');

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 20,  // Nama SPG
            'C' => 20,  // Nama Toko
            'D' => 15,  // Kode Item
            'E' => 30,  // Nama Barang
            'F' => 12,  // Ukuran
            'G' => 15,  // Stock Awal Bulan
            'H' => 18,  // Qty Masuk Minggu 1
            'I' => 18,  // Qty Masuk Minggu 2
            'J' => 18,  // Qty Masuk Minggu 3
            'K' => 18,  // Qty Masuk Minggu 4
            'L' => 18,  // Qty Masuk Minggu 5
            'M' => 25,  // Catatan Minggu 1
            'N' => 25,  // Catatan Minggu 2
            'O' => 25,  // Catatan Minggu 3
            'P' => 25,  // Catatan Minggu 4
            'Q' => 25,  // Catatan Minggu 5
            'R' => 15,  // Stock Minggu 1
            'S' => 15,  // Stock Minggu 2
            'T' => 15,  // Stock Minggu 3
            'U' => 15,  // Stock Minggu 4
            'V' => 15,  // Stock Minggu 5
        ];
    }
}