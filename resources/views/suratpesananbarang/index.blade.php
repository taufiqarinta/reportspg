<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Surat Pesanan Barang') }}
            </h2>
            @if(auth()->user()->department === 'SLS' || auth()->user()->department === 'SLS SUPER')
            <a href="{{ route('suratpesananbarang.create') }}" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Data
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 card-all">
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

                <!-- Form Filter -->
                <div class="w-full sm:w-auto">
                    <form method="GET" action="{{ route('suratpesananbarang.index') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        
                        <!-- Search -->
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                            placeholder="Cari no. surat, pengirim, penerima..." 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        
                        <!-- Status -->
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diketahui" {{ ($filters['status'] ?? '') == 'diketahui' ? 'selected' : '' }}>Approved by SLS</option>
                            <option value="approved" {{ ($filters['status'] ?? '') == 'approved' ? 'selected' : '' }}>Approved by FNC</option>
                            <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <!-- Start Date -->
                        <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Dari Tanggal">
                        
                        <!-- End Date -->
                        <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Sampai Tanggal">

                        <!-- Tombol Aksi -->
                        <div class="flex gap-2 col-span-1 sm:col-span-2 justify-end">
                            @if(in_array(auth()->user()->department, ['SLS', 'FNC', 'SLS SUPER']))
                                <a href="{{ route('suratpesananbarang.export-excel') }}?{{ http_build_query($filters) }}" 
                                    class="flex-1 text-center px-3 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                                    Export Excel
                                </a>
                            @endif

                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Cari
                            </button>

                            @if($filters && count(array_filter($filters)) > 0)
                                <a href="{{ route('suratpesananbarang.index') }}" 
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
                                        <th class="column-no-surat">No. Surat</th>
                                        <th class="column-tanggal">Tanggal Surat</th>
                                        <th class="column-pengirim">Pesanan Dari</th>
                                        <th class="column-penerima">Nama Sales</th>
                                        <th class="column-penerima">Dikirim Ke</th>
                                        <th class="column-pemesan hidden">Pemesan</th>
                                        <th class="column-jenis-harga">Jenis Harga</th>
                                        <th class="column-jenis-harga">Nomor DO</th>
                                        <th class="column-total">Total BOX</th>
                                        <th class="column-total">Total</th>
                                        <th class="column-status">Status</th>
                                        @if(auth()->user()->department === 'FNC' || auth()->user()->department === 'SLS SUPER')
                                        <th class="column-dibuat-oleh">Dibuat Oleh</th>
                                        @endif
                                        <th class="column-aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($suratPesananBarangs as $spb)
                                    <tr>
                                        <td class="column-no-surat">{{ $spb->nomor_surat }}</td>
                                        <td class="column-tanggal">{{ $spb->tanggal_surat->format('d/m/Y') }}</td>
                                        <td class="column-pengirim">{{ $spb->pengirim }}</td>
                                        <td class="column-penerima">{{ $spb->penerima }}</td>
                                        <td class="column-penerima">{{ $spb->dikirim_ke }}</td>
                                        <td class="column-pemesan hidden">{{ $spb->pemesan }}</td>
                                        <td class="column-jenis-harga">{{ $spb->jenis_harga }}</td>
                                        <td class="column-jenis-harga">{{ $spb->nomor_do }}</td>
                                        <td class="column-total">{{ number_format($spb->total_jumlahbox, 0, ',', '.') }} Box</td>
                                        <td class="column-total">Rp {{ number_format($spb->total_keseluruhan, 0, ',', '.') }}</td>
                                        <td class="column-status">
                                            @if($spb->status === 'draft')
                                                <span class="badge badge-gray">Draft</span>
                                            @elseif($spb->status === 'pending')
                                                <span class="badge badge-yellow">Pending</span>
                                            @elseif($spb->status === 'diketahui')
                                                <span class="badge badge-green">Approved by SLS</span>
                                            @elseif($spb->status === 'approved')
                                                <span class="badge badge-green">Approved by FNC</span>
                                            @else
                                                <span class="badge badge-red">Unknown</span>
                                            @endif
                                        </td>
                                        @if(auth()->user()->department === 'FNC' || auth()->user()->department === 'SLS SUPER')
                                        <td class="column-dibuat-oleh">{{ $spb->creator->name ?? '-' }}</td>
                                        @endif
                                        <td class="column-aksi">
                                            <div class="action-buttons">
                                                <a href="{{ route('suratpesananbarang.show', $spb->id) }}" class="btn btn-blue">
                                                    Detail
                                                </a>
                                                <a href="{{ route('suratpesananbarang.export-pdf', $spb->id) }}" class="btn btn-purple">
                                                    Export PDF
                                                </a>
                                                
                                                @if(auth()->user()->department === 'SLS')
                                                    @if(in_array($spb->status, ['draft', 'pending']))
                                                    <a href="{{ route('suratpesananbarang.edit', $spb->id) }}" class="btn btn-yellow">
                                                        Edit
                                                    </a>
                                                    @endif
                                                    
                                                    @if($spb->status === 'draft')
                                                    <form action="{{ route('suratpesananbarang.submit', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Submit surat pesanan ini untuk approval?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green">
                                                            Submit
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    @if(in_array($spb->status, ['draft', 'pending']))
                                                    <form action="{{ route('suratpesananbarang.destroy', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-red">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                    @endif
                                                @endif

                                                @if(auth()->user()->department === 'FNC' || auth()->user()->department === 'SLS SUPER')
                                                    @if(in_array($spb->status, ['pending', 'approved']))
                                                    <a href="{{ route('suratpesananbarang.edit', $spb->id) }}" class="btn btn-yellow">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(in_array($spb->status, ['draft', 'pending']))
                                                    <form action="{{ route('suratpesananbarang.destroy', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-red">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if($spb->status === 'pending' && auth()->user()->department === 'SLS SUPER' )
                                                    <form action="{{ route('suratpesananbarang.diketahui', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Approve surat pesanan ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green">
                                                            Approve by SLS
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    @if($spb->status === 'diketahui' && auth()->user()->department === 'FNC')
                                                    <form action="{{ route('suratpesananbarang.approve', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Approve surat pesanan ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green">
                                                            Approve by FNC
                                                        </button>
                                                    </form>
                                                    
                                                    <button onclick="confirmReject({{ $spb->id }})" class="btn btn-red">
                                                        Reject
                                                    </button>
                                                    @endif

                                                    {{-- Tombol Batalkan Approval SLS --}}
                                                    @if($spb->status === 'diketahui' && auth()->user()->department === 'SLS SUPER')
                                                    <form action="{{ route('suratpesananbarang.cancel-approval-sls', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Batalkan approval SLS? Status akan kembali ke Pending.')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-orange">
                                                            Batalkan Approval SLS
                                                        </button>
                                                    </form>
                                                    @endif

                                                    {{-- Tombol Batalkan Approval FNC --}}
                                                    @if($spb->status === 'approved' && auth()->user()->department === 'FNC')
                                                    <form action="{{ route('suratpesananbarang.cancel-approval-fnc', $spb->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Batalkan approval FNC? Status akan kembali ke Approved by SLS.')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-orange">
                                                            Batalkan Approval FNC
                                                        </button>
                                                    </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->department === 'FNC' ? '8' : '7' }}" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $suratPesananBarangs->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->department === 'FNC')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReject(id) {
            Swal.fire({
                title: 'Reject Surat Pesanan?',
                text: "Apakah Anda yakin ingin menolak surat pesanan barang ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reject!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/suratpesananbarang/${id}/reject`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const catatanInput = document.createElement('input');
                    catatanInput.type = 'hidden';
                    catatanInput.name = 'catatan';
                    catatanInput.value = 'Rejected by Finance';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(catatanInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
    @endif

    <style>
        .btn-orange {
            background-color: #f97316;
            color: white;
        }

        .btn-orange:hover {
            background-color: #ea580c;
        }

        .btn-purple {
            background-color: #8b5cf6;
            color: white;
        }

        .btn-purple:hover {
            background-color: #7c3aed;
        }
        /* Custom CSS untuk tabel responsif - SAMA PERSIS dengan referensi */
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
            min-width: 1000px; /* Minimum width untuk memaksa scroll */
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

        /* Lebar kolom spesifik untuk Surat Pesanan Barang */
        .column-no-surat { width: 120px; min-width: 120px; }
        .column-tanggal { width: 100px; min-width: 100px; }
        .column-pengirim { width: 120px; min-width: 120px; }
        .column-penerima { width: 120px; min-width: 120px; }
        .column-pemesan { width: 120px; min-width: 120px; }
        .column-jenis-harga { width: 120px; min-width: 120px; }
        .column-total { width: 120px; min-width: 120px; }
        .column-status { width: 100px; min-width: 100px; }
        .column-dibuat-oleh { width: 120px; min-width: 120px; }
        .column-aksi { width: 50px; min-width: 50px; }

        /* Styling untuk badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 9999px;
        }

        .badge-gray {
            background-color: #f3f4f6;
            color: #374151;
        }

        .badge-yellow {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }

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

        .btn-green {
            background-color: #10b981;
            color: white;
        }

        .btn-green:hover {
            background-color: #059669;
        }

        .btn-red {
            background-color: #dc2626;
            color: white;
        }

        .btn-red:hover {
            background-color: #b91c1c;
        }

        /* Responsive design untuk mobile */
        @media (max-width: 768px) {
            .table-container {
                margin: 0; /* hilangkan margin negatif */
                padding: 0 1rem; /* tambahkan padding kiri-kanan */
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .card-all {
                margin: 0; /* hilangkan margin negatif */
                padding: 0 1rem; /* tambahkan padding kiri-kanan */
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
            
            .responsive-table {
                min-width: 1100px; /* Lebih lebar untuk mobile jika perlu */
            }
        }

        /* Untuk layar yang sangat kecil */
        @media (max-width: 640px) {
            .responsive-table {
                min-width: 1000px;
            }
            
            .column-aksi {
                width: 180px;
                min-width: 180px;
            }
        }
    </style>
</x-app-layout>