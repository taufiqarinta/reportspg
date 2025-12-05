<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Agen') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('daftar-agen.create') }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah
                </a>
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

            <!-- Header Section dengan Search -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div class="w-full sm:w-auto">
                    <form method="GET" action="{{ route('daftar-agen.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Search -->
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                            placeholder="Cari nama agen, sales, NPWP..." 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <!-- Tombol Aksi -->
                        <div class="flex gap-2 col-span-1 sm:col-span-3 justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Cari
                            </button>

                            @if($filters && count(array_filter($filters)) > 0)
                                <a href="{{ route('daftar-agen.index') }}" 
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
                                        <th class="column-npwp">NPWP</th>
                                        <th class="column-nama-agen">Nama Agen</th>
                                        <th class="column-nama-sales">Nama Sales</th>
                                        <th class="column-alamat">Alamat</th>
                                        <th class="column-created">Dibuat</th>
                                        <th class="column-aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftarAgens as $agen)
                                    <tr>
                                        <td class="column-npwp">{{ $agen->npwp ?? '-' }}</td>
                                        <td class="column-nama-agen">{{ $agen->nama_agen }}</td>
                                        <td class="column-nama-sales">{{ $agen->nama_sales ?? '-' }}</td>
                                        <td class="column-alamat">{{ Str::limit($agen->alamat, 50) }}</td>
                                        <td class="column-created">{{ $agen->created_at->format('d/m/Y') }}</td>
                                        <td class="column-aksi">
                                            <div class="action-buttons">
                                                <a href="{{ route('daftar-agen.show', $agen->id) }}" class="btn btn-blue">
                                                    Detail
                                                </a>
                                                <a href="{{ route('daftar-agen.edit', $agen->id) }}" class="btn btn-yellow">
                                                    Edit
                                                </a>
                                                <form action="{{ route('daftar-agen.destroy', $agen->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-red">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $daftarAgens->withQueryString()->links() }}
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
        .column-npwp { width: 150px; min-width: 150px; }
        .column-nama-agen { width: 200px; min-width: 200px; }
        .column-nama-sales { width: 150px; min-width: 150px; }
        .column-alamat { width: 250px; min-width: 250px; white-space: normal; }
        .column-created { width: 100px; min-width: 100px; }
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
                min-width: 800px;
            }
        }
    </style>
</x-app-layout>