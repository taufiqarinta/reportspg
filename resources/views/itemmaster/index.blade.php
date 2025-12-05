<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Item Master') }}
            </h2>
            <!-- <a href="{{ route('itemmaster.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Item Baru
            </a> -->
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Form -->
            <div class="mb-6">
                <form method="GET" action="{{ route('itemmaster.index') }}" class="flex gap-3 items-center">
                    
                    <!-- Input -->
                    <input type="text" 
                        name="search" 
                        value="{{ $filters['search'] ?? '' }}" 
                        placeholder="Cari kode item, nama, atau ukuran..." 
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    
                    <!-- Tombol Cari -->
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Cari
                    </button>

                    <!-- Tombol Reset -->
                    @if(!empty($filters['search']))
                        <a href="{{ route('itemmaster.index') }}" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md">
                            Reset
                        </a>
                    @endif

                </form>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    @if($items->count() > 0)
                        <!-- Container untuk tabel dengan scroll horizontal -->
                        <div class="table-container">
                            <div class="overflow-x-scroll">
                                <table class="responsive-table">
                                    <thead>
                                        <tr>
                                            <th class="column-no">No</th>
                                            <th class="column-kode">Itemcode</th>
                                            <th class="column-nama">Motif</th>
                                            <th class="column-ukuran">Ukuran</th>
                                            <th class="column-aksi">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $index => $item)
                                            <tr>
                                                <td class="column-no">{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                                                <td class="column-kode">{{ $item->item_code }}</td>
                                                <td class="column-nama">{{ $item->item_name }}</td>
                                                <td class="column-ukuran">{{ $item->ukuran ?? '-' }}</td>
                                                <td class="column-aksi">
                                                    <div class="action-buttons">
                                                        <a href="{{ route('itemmaster.show', $item) }}" 
                                                           class="btn btn-blue">
                                                            Detail
                                                        </a>
                                                        <!-- <a href="{{ route('itemmaster.edit', $item) }}" 
                                                           class="btn btn-yellow">
                                                            Edit
                                                        </a> -->
                                                        <!-- <form action="{{ route('itemmaster.destroy', $item) }}" 
                                                              method="POST" 
                                                              class="inline-form" 
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-red">
                                                                Hapus
                                                            </button>
                                                        </form> -->
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            {{ $items->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada data item.</p>
                            @if(!empty($filters['search']))
                                <p class="text-gray-500 mt-2">Tidak ditemukan item dengan kata kunci "{{ $filters['search'] }}"</p>
                            @endif
                            <!-- <a href="{{ route('itemmaster.create') }}" 
                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Tambah Item Pertama
                            </a> -->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
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
            white-space: nowrap;
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
        .column-no { width: 50px; min-width: 50px; text-align: center; }
        .column-kode { width: 150px; min-width: 150px; }
        .column-nama { width: 300px; min-width: 300px; }
        .column-ukuran { width: 100px; min-width: 100px; }
        .column-aksi { width: 50px; min-width: 50px; }

        /* Styling untuk tombol aksi */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn {
            display: block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            text-align: center;
            border-radius: 0.25rem;
            text-decoration: none;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
        }

        .inline-form {
            display: block;
            margin: 0;
        }

        .btn-blue {
            background-color: #2563eb;
            color: white;
        }

        .btn-blue:hover {
            background-color: #1d4ed8;
        }

        .btn-yellow {
            background-color: #f59e0b;
            color: white;
        }

        .btn-yellow:hover {
            background-color: #d97706;
        }

        .btn-red {
            background-color: #dc2626;
            color: white;
        }

        .btn-red:hover {
            background-color: #b91c1c;
        }

        /* Responsive untuk mobile */
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
            
            .p-4 {
                padding: 1rem;
            }
        }
    </style>
</x-app-layout>