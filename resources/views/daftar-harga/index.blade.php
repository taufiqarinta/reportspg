<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Harga') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('daftarharga.export-excel') }}?{{ http_build_query($filters) }}" 
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>

                @if(auth()->user()->department === 'FNC' || auth()->user()->department === 'SLS SUPER')
                <!-- Tombol Import Data PL Baru -->
                <a href="{{ route('daftarharga.import-form') }}" 
                    style="background-color: #2563eb; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; display: flex; align-items: center; text-decoration: none;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'" 
                    onmouseout="this.style.backgroundColor='#2563eb'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                    Import Data PL
                </a>
                <a href="{{ route('daftarharga.create') }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Data
                </a>
                @endif
            </div>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
            @endif

            <!-- Header Section dengan Search & Filter -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div class="w-full sm:w-auto">
                    <form method="GET" action="{{ route('daftarharga.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Search -->
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                            placeholder="Cari type, brand, kategori..." 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <!-- Tombol Aksi -->
                        <div class="flex gap-2 col-span-1 sm:col-span-3 justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Cari
                            </button>

                            @if($filters && count(array_filter($filters)) > 0)
                                <a href="{{ route('daftarharga.index') }}" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <!-- Container untuk tabel dengan scroll horizontal -->
                    <div class="table-container">
                        <div class="overflow-x-scroll">
                            <table class="responsive-table">
                                <thead>
                                    <tr>
                                        <th class="column-type">Type</th>
                                        <th class="column-kw">KW</th>
                                        <th class="column-brand">Brand</th>
                                        <th class="column-ukuran">Ukuran</th>
                                        <th class="column-karton">Karton</th>
                                        <th class="column-kategori">Kategori</th>
                                        <th class="column-kel-harga">Kel. Harga</th>
                                        <th class="column-harga-franco">Harga Franco</th>
                                        <th class="column-harga-loco">Harga Loco</th>
                                        <th class="column-aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftarHargas as $harga)
                                    <tr>
                                        <td class="column-type">{{ $harga->type }}</td>
                                        <td class="column-kw">{{ $harga->kw }}</td>
                                        <td class="column-brand">{{ $harga->brand }}</td>
                                        <td class="column-ukuran">{{ $harga->ukuran }}</td>
                                        <td class="column-karton">{{ $harga->karton }}</td>
                                        <td class="column-kategori">{{ $harga->kategori }}</td>
                                        <td class="column-kel-harga">{{ $harga->kel_harga_miss2 }}</td>
                                        <td class="column-harga-franco">Rp {{ number_format($harga->harga_franco, 2, ',', '.') }}</td>
                                        <td class="column-harga-loco">Rp {{ number_format($harga->harga_loco, 2, ',', '.') }}</td>
                                        <td class="column-aksi">
                                            <div class="action-buttons">
                                                <a href="{{ route('daftarharga.show', $harga->id) }}" class="btn btn-blue">
                                                    Detail
                                                </a>
                                                @if(auth()->user()->department === 'FNC' || auth()->user()->department === 'SLS SUPER')
                                                <a href="{{ route('daftarharga.edit', $harga->id) }}" class="btn btn-yellow">
                                                    Edit
                                                </a>
                                                <form action="{{ route('daftarharga.destroy', $harga->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-red">
                                                        Hapus
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $daftarHargas->links() }}
                    </div>
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
            min-width: 1200px;
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
        .column-type { width: 150px; min-width: 150px; }
        .column-kw { width: 80px; min-width: 80px; }
        .column-brand { width: 80px; min-width: 80px; }
        .column-ukuran { width: 100px; min-width: 100px; }
        .column-karton { width: 120px; min-width: 120px; }
        .column-kategori { width: 120px; min-width: 120px; }
        .column-kel-harga { width: 100px; min-width: 100px; }
        .column-harga-franco { width: 120px; min-width: 120px; }
        .column-harga-loco { width: 120px; min-width: 120px; }
        .column-aksi { width: 150px; min-width: 150px; }

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

        @media (max-width: 768px) {
            .table-container {
                margin: 0; /* hilangkan margin negatif */
                padding: 0 1rem; /* tambahkan padding kiri-kanan */
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
            
            .responsive-table {
                min-width: 1200px;
            }
        }
    </style>
</x-app-layout>