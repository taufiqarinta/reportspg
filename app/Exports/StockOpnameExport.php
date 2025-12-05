<?php

namespace App\Exports;

use App\Models\StockOpname;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockOpnameExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = StockOpname::with(['details', 'toko', 'user']);
        
        if (isset($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }
        
        if (isset($this->filters['bulan'])) {
            $query->where('bulan', $this->filters['bulan']);
        }
        
        if (isset($this->filters['user_id']) && $this->filters['user_role'] == 0) {
            $query->where('user_id', $this->filters['user_id']);
        }
        
        if (isset($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('kode_opname', 'like', '%' . $search . '%')
                  ->orWhere('nama_spg', 'like', '%' . $search . '%')
                  ->orWhereHas('toko', function($q) use ($search) {
                      $q->where('nama_toko', 'like', '%' . $search . '%');
                  });
            });
        }
        
        return $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Opname',
            'Tanggal',
            'Nama Toko',
            'Tahun',
            'Bulan',
            'Status',
            'Nama SPG',
            'Item Code',
            'Nama Barang',
            'Ukuran',
            'Stock',
            'Keterangan'
        ];
    }

    public function map($opname): array
    {
        $rows = [];
        
        foreach ($opname->details as $detail) {
            $rows[] = [
                $opname->kode_opname,
                $opname->tanggal->format('d/m/Y'),
                $opname->nama_toko,
                $opname->tahun,
                $this->getMonthName($opname->bulan),
                ucfirst($opname->status),
                $opname->nama_spg,
                $detail->item_code,
                $detail->nama_barang,
                $detail->ukuran,
                $detail->stock,
                $detail->keterangan
            ];
        }
        
        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ]
            ],
        ];
    }

    private function getMonthName($month)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $months[$month] ?? $month;
    }
}