<?php

namespace App\Http\Controllers;

use App\Models\FormReportSPG;
use App\Models\FormReportSPGDetail;
use App\Models\ItemMaster;
use App\Models\DaftarToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportSPGExport;

class ReportSPGController extends Controller
{
    /**
     * Helper function untuk check authorization berdasarkan role
     */
    private function checkAuthorization(FormReportSPG $reportspg)
    {
        dd($reportspg->user_id);
        $user = Auth::user();
        
        // Jika user adalah admin (role_as = 1), izinkan akses
        if ($user->role_as == 1) {
            return true;
        }
        
        // Jika user biasa (role_as = 0), cek apakah data miliknya
        if ($reportspg->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return true;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Jika role_as = 1 (admin), tampilkan semua data
        // Jika role_as = 0 (user biasa), tampilkan hanya data user tersebut
        $query = FormReportSPG::with(['details', 'toko']);
            
        if ($user->role_as == 0) {
            $query->where('user_id', $user->id);
        }
        
        // Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        // Filter berdasarkan nama SPG jika role admin
        if ($user->role_as == 1 && $request->filled('nama_spg')) {
            $query->where('nama_spg', 'like', '%' . $request->nama_spg . '%');
        }
        
        // Filter berdasarkan kode report
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_report', 'like', '%' . $search . '%')
                ->orWhere('nama_spg', 'like', '%' . $search . '%')
                ->orWhereHas('toko', function($q) use ($search) {
                    $q->where('nama_toko', 'like', '%' . $search . '%')
                        ->orWhere('kota', 'like', '%' . $search . '%');
                });
            });
        }
        
        $reports = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Simpan filter untuk view
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nama_spg' => $request->nama_spg,
            'search' => $request->search, // <-- Tambahkan search ke filters
        ];
        
        return view('reportspg.index', compact('reports', 'filters'));
    }

    /**
     * Export data to Excel
     */
    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        
        // Validasi tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'nama_spg' => 'nullable|string|max:255',
        ]);
        
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nama_spg' => $request->nama_spg,
            'user_role' => $user->role_as,
            'user_id' => $user->id,
        ];
        
        $filename = 'report_spg_' . date('Ymd_His') . '.xlsx';
        
        return Excel::download(new ReportSPGExport($filters), $filename);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cek apakah sudah ada report untuk hari ini
        // Hanya berlaku untuk user biasa, admin bisa buat berapapun
        $user = Auth::user();

        $tokoList = DaftarToko::where('kode_spg', $user->id_customer)
            ->orderBy('nama_toko')
            ->get(['id', 'nama_toko', 'kota']);

        
        // if ($user->role_as == 0) {
        //     $todayReport = FormReportSPG::where('user_id', $user->id)
        //         ->whereDate('tanggal', now()->toDateString())
        //         ->first();
                
        //     if ($todayReport) {
        //         return redirect()->route('reportspg.show', $todayReport)
        //             ->with('info', 'Anda sudah membuat report untuk hari ini. Anda dapat mengedit report tersebut.');
        //     }
        // }
        
        $items = ItemMaster::orderBy('item_name')->get(['item_code', 'item_name', 'ukuran']);
        return view('reportspg.create', compact('items', 'tokoList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'toko_id' => 'required',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|exists:item_master,item_code',
            'items.*.qty_terjual' => 'required|integer|min:0',
            'items.*.qty_masuk' => 'required|integer|min:0',
            'items.*.catatan' => 'nullable|string',
        ]);

        try {
            // Mulai transaksi
            \DB::beginTransaction();

            // Buat header report
            $report = FormReportSPG::create([
                'kode_report' => FormReportSPG::generateKodeReport(),
                'tanggal' => $request->tanggal,
                'user_id' => Auth::id(),
                'nama_spg' => Auth::user()->name,
                'toko_id' => $request->toko_id,
            ]);

            // Simpan detail items
            foreach ($request->items as $itemData) {
                $itemMaster = ItemMaster::where('item_code', $itemData['item_code'])->first();
                
                if ($itemMaster) {
                    FormReportSPGDetail::create([
                        'report_id' => $report->id,
                        'item_code' => $itemData['item_code'],
                        'nama_barang' => $itemMaster->item_name,
                        'ukuran' => $itemMaster->ukuran,
                        'qty_terjual' => $itemData['qty_terjual'],
                        'qty_masuk' => $itemData['qty_masuk'],
                        'catatan' => $itemData['catatan'] ?? null,
                    ]);
                }
            }

            \DB::commit();

            return redirect()->route('reportspg.show', $report)
                ->with('success', 'Report penjualan berhasil disimpan.');
                
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FormReportSPG $reportspg)
    {
        // Gunakan helper function untuk check authorization
        $this->checkAuthorization($reportspg);
        
        $reportspg->load('details');
        return view('reportspg.show', compact('reportspg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormReportSPG $reportspg)
    {
        // Gunakan helper function untuk check authorization
        $this->checkAuthorization($reportspg);
        
        $items = ItemMaster::orderBy('item_name')->get(['item_code', 'item_name', 'ukuran']);
        $reportspg->load('details');
        
        return view('reportspg.edit', compact('reportspg', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormReportSPG $reportspg)
    {
        // Gunakan helper function untuk check authorization
        $this->checkAuthorization($reportspg);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|exists:item_master,item_code',
            'items.*.qty_terjual' => 'required|integer|min:0',
            'items.*.qty_masuk' => 'required|integer|min:0',
            'items.*.catatan' => 'nullable|string',
        ]);

        try {
            // Mulai transaksi
            \DB::beginTransaction();

            // Update tanggal report
            $reportspg->update([
                'tanggal' => $request->tanggal,
            ]);

            // Hapus detail lama
            $reportspg->details()->delete();

            // Simpan detail items baru
            foreach ($request->items as $itemData) {
                $itemMaster = ItemMaster::where('item_code', $itemData['item_code'])->first();
                
                if ($itemMaster) {
                    FormReportSPGDetail::create([
                        'report_id' => $reportspg->id,
                        'item_code' => $itemData['item_code'],
                        'nama_barang' => $itemMaster->item_name,
                        'ukuran' => $itemMaster->ukuran,
                        'qty_terjual' => $itemData['qty_terjual'],
                        'qty_masuk' => $itemData['qty_masuk'],
                        'catatan' => $itemData['catatan'] ?? null,
                    ]);
                }
            }

            \DB::commit();

            return redirect()->route('reportspg.show', $reportspg)
                ->with('success', 'Report penjualan berhasil diperbarui.');
                
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormReportSPG $reportspg)
    {
        // Gunakan helper function untuk check authorization
        $this->checkAuthorization($reportspg);

        $reportspg->delete();
        
        return redirect()->route('reportspg.index')
            ->with('success', 'Report penjualan berhasil dihapus.');
    }

    /**
     * API untuk get data item
     */
    public function getItems(Request $request)
    {
        $search = $request->input('q');
        
        $items = ItemMaster::when($search, function($query, $search) {
                return $query->where('item_code', 'like', '%' . $search . '%')
                           ->orWhere('item_name', 'like', '%' . $search . '%');
            })
            ->orderBy('item_name')
            ->limit(20)
            ->get(['item_code', 'item_name', 'ukuran']);
            
        $formattedItems = $items->map(function($item) {
            return [
                'id' => $item->item_code, // Gunakan item_code sebagai ID
                'text' => "{$item->item_code} - {$item->item_name} - {$item->ukuran}",
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'ukuran' => $item->ukuran
            ];
        });
        
        return response()->json($formattedItems);
    }
}