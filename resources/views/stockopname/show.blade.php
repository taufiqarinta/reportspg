<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Stock Opname') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('stockopname.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Kode Opname</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $stockopname->kode_opname }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Stock Opname</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $stockopname->tanggal->format('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Toko Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-4 bg-blue-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Nama Toko</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $stockopname->nama_toko }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Periode</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $stockopname->bulan }}/{{ $stockopname->tahun }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Dibuat Oleh</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $stockopname->nama_spg }}</p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-6">
                        <!-- Container untuk tabel dengan scroll horizontal -->
                        <div class="table-container">
                            <div class="overflow-x-scroll">
                                <table class="responsive-table">
                                    <thead>
                                        <tr>
                                            <th class="column-no">No</th>
                                            <th class="column-kode">Kode Item</th>
                                            <th class="column-nama">Nama Barang</th>
                                            <th class="column-ukuran">Ukuran</th>
                                            <th class="column-stock">Stock</th>
                                            <th class="column-keterangan">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($stockopname->details as $index => $detail)
                                        <tr>
                                            <td class="column-no text-center">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="column-kode">
                                                <span class="font-mono">{{ $detail->item_code }}</span>
                                            </td>
                                            <td class="column-nama">
                                                {{ $detail->nama_barang }}
                                            </td>
                                            <td class="column-ukuran">
                                                {{ $detail->ukuran ?? '-' }}
                                            </td>
                                            <td class="column-stock text-center">
                                                <span class="inline-flex items-center justify-center px-2 py-1 bg-blue-100 text-blue-800 rounded-md text-sm font-medium">
                                                    {{ number_format($detail->stock, 0, ',', '.') }} Box
                                                </span>
                                            </td>
                                            <td class="column-keterangan">
                                                {{ $detail->keterangan ?? '-' }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8 text-gray-500">
                                                Tidak ada data item
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    @if($stockopname->details->count() > 0)
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="4" class="text-right font-semibold text-gray-900 p-4">
                                                TOTAL
                                            </td>
                                            <td class="text-center font-semibold text-gray-900 p-4">
                                                {{ number_format($stockopname->details->sum('stock'), 0, ',', '.') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Table Container Styling */
        .table-container {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            overflow: hidden;
        }

        .overflow-x-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .overflow-x-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-scroll::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }

        .overflow-x-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .overflow-x-scroll::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Responsive Table Styling */
        .responsive-table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .responsive-table th {
            background-color: #f9fafb;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .responsive-table td {
            font-size: 0.875rem;
            color: #374151;
        }

        .responsive-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Lebar kolom spesifik */
        .column-no { 
            width: 60px; 
            min-width: 60px; 
        }
        .column-kode { 
            width: 120px; 
            min-width: 120px; 
        }
        .column-nama { 
            width: 250px; 
            min-width: 250px; 
        }
        .column-ukuran { 
            width: 100px; 
            min-width: 100px; 
        }
        .column-stock { 
            width: 100px; 
            min-width: 100px; 
        }
        .column-keterangan { 
            width: 200px; 
            min-width: 200px; 
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .table-container {
                margin: 0;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
            
            .responsive-table {
                min-width: 800px;
            }
            
            .max-w-9xl {
                max-width: 100%;
                padding: 0 0.5rem;
            }
            
            .p-6 {
                padding: 1rem;
            }
            
            .flex-col {
                flex-direction: column;
            }
            
            .space-x-4 {
                gap: 0.5rem;
            }
        }
    </style>
</x-app-layout>