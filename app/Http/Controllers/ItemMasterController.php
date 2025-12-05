<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use Illuminate\Http\Request;

class ItemMasterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $items = ItemMaster::when($search, function($query, $search) {
                return $query->where('item_code', 'like', '%' . $search . '%')
                           ->orWhere('item_name', 'like', '%' . $search . '%')
                           ->orWhere('ukuran', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
            
        // Simpan filter untuk view
        $filters = [
            'search' => $search,
        ];
        
        return view('itemmaster.index', compact('items', 'filters'));
    }

    public function create()
    {
        return view('itemmaster.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|string|max:50|unique:item_master',
            'item_name' => 'required|string|max:255',
            'ukuran' => 'nullable|string|max:50',
        ]);

        ItemMaster::create($validated);

        return redirect()->route('itemmaster.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function show($id)
    {
        $itemMaster = ItemMaster::findOrFail($id);
        return view('itemmaster.show', compact('itemMaster'));
    }

    public function edit($id) 
    {
        $itemMaster = ItemMaster::findOrFail($id);
        return view('itemmaster.edit', compact('itemMaster'));
    }

    public function update(Request $request, $id) 
    {
        $itemMaster = ItemMaster::findOrFail($id); 
        
        $validated = $request->validate([
            'item_code' => 'required|string|max:50|unique:item_master,item_code,' . $itemMaster->id,
            'item_name' => 'required|string|max:255',
            'ukuran' => 'nullable|string|max:50',
        ]);

        $itemMaster->update($validated);

        return redirect()->route('itemmaster.index')
            ->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $itemMaster = ItemMaster::findOrFail($id); 
        $itemMaster->delete();

        return redirect()->route('itemmaster.index')
            ->with('success', 'Item berhasil dihapus.');
    }
}