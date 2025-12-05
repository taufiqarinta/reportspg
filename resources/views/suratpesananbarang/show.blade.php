<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Surat Pesanan Barang') }}
            </h2>
            <a href="{{ route('suratpesananbarang.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Main Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">No. Surat:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->nomor_surat }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tanggal Surat:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->tanggal_surat->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Pesanan Dari:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->pengirim }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Penerima Barang:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->penerima }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dikirim Ke:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->dikirim_ke }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tanggal Kirim:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->tanggal_kirim->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Jenis Harga:</p>
                            <p class="text-lg font-semibold">{{ $suratpesananbarang->jenis_harga == 'franco' ? 'Harga Franco' : 'Harga Loco' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 hidden">Pemesan:</p>
                            <p class="text-lg font-semibold hidden">{{ $suratpesananbarang->pemesan }}</p>
                        </div>
                    </div>

                    <!-- Status & Approval Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Status:</p>
                                @if($suratpesananbarang->status === 'draft')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                @elseif($suratpesananbarang->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Approval</span>
                                @elseif($suratpesananbarang->status === 'diketahui')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved by SLS</span>
                                @elseif($suratpesananbarang->status === 'approved')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unknown</span>
                                @endif
                            </div>
                            @if($suratpesananbarang->approved_by)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Approved/Rejected By:</p>
                                <p class="text-base">{{ $suratpesananbarang->approver->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $suratpesananbarang->approved_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                        </div>
                        @if($suratpesananbarang->catatan)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700">Catatan:</p>
                            <p class="text-base mt-1">{{ $suratpesananbarang->catatan }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Detail Barang Table -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Detail Barang</h3>
                        
                        <!-- Container untuk tabel dengan scroll horizontal -->
                        <div class="table-container">
                            <div class="overflow-x-scroll">
                                <table class="responsive-table">
                                    <thead>
                                        <tr>
                                            <th class="column-no">No</th>
                                            <th class="column-ukuran">Ukuran</th>
                                            <th class="column-product">Nama Product</th>
                                            <th class="column-brand">Brand</th>
                                            <th class="column-kw">KW</th>
                                            <th class="column-jumlah">Jumlah/Box</th>
                                            <th class="column-harga">Harga Satuan/Box</th>
                                            <th class="column-disc">Disc (Rp)</th>
                                            <th class="column-biaya">Biaya Tambahan Ekspedisi</th>
                                            <th class="column-total">Total Rp</th>
                                            <th class="column-keterangan">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suratpesananbarang->details as $index => $detail)
                                        <tr>
                                            <td class="column-no">{{ $index + 1 }}</td>
                                            <td class="column-ukuran">{{ $detail->ukuran ?? '-' }}</td>
                                            <td class="column-product">{{ $detail->nama_product }}</td>
                                            <td class="column-brand">{{ $detail->brand ?? '-' }}</td>
                                            <td class="column-kw">{{ $detail->kw ?? '-' }}</td>
                                            <td class="column-jumlah text-right">{{ number_format($detail->jumlah_box, 0, '.', '.') }}</td>
                                            <td class="column-harga text-right">Rp {{ number_format($detail->harga_satuan_box, 2, ',', '.') }}</td>
                                            <td class="column-disc text-right">Rp {{ number_format($detail->disc, 2, ',', '.') }}</td>
                                            <td class="column-biaya text-right">Rp {{ number_format($detail->biaya_tambahan_ekspedisi, 2, ',', '.') }}</td>
                                            <td class="column-total text-right">Rp {{ number_format($detail->total_rp, 2, ',', '.') }}</td>
                                            <td class="column-keterangan">{{ $detail->keterangan ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-right font-bold border">Total Keseluruhan:</td>
                                            <td class="column-jumlah text-right font-bold">{{ number_format($suratpesananbarang->total_jumlahbox, 0, ',', '.') }}</td>
                                            <td colspan="3"></td>
                                            <td class="column-total text-right font-bold">Rp {{ number_format($suratpesananbarang->total_keseluruhan, 0, ',', '.') }}</td>
                                            <td class="column-keterangan"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Signature Section -->
                    <table class="w-full mt-8 text-sm text-center border border-gray-400 border-collapse">
                        <thead>
                            <tr>
                                <th class="font-medium py-2 border border-gray-400 w-1/2">Sales</th>
                                @if($suratpesananbarang->status === 'rejected')
                                    <th class="font-medium py-2 border border-gray-400 w-1/2">Ditolak</th>
                                @else
                                    <th class="font-medium py-2 border border-gray-400 w-1/2">Disetujui</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- <td class="py-8 border border-gray-400">
                                    {{ $suratpesananbarang->penerima ?? '-' }}
                                </td> -->
                                <td class="py-8 border border-gray-400">
                                    {{ $suratpesananbarang->diketahuir->name ?? '-' }}
                                </td>
                                <td class="py-8 border border-gray-400">
                                    {{ $suratpesananbarang->approver->name ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-3">
                        @if(auth()->user()->department === 'SLS')
                            @if(in_array($suratpesananbarang->status, ['draft', 'pending']))
                            <a href="{{ route('suratpesananbarang.edit', $suratpesananbarang->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            @endif
                        @endif

                        @if(auth()->user()->department === 'FNC' && $suratpesananbarang->status === 'pending')
                        <!-- <button onclick="confirmApprove()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Approve 
                        </button>
                        
                        <button onclick="confirmReject()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Reject
                        </button> -->

                        <!-- Hidden Forms -->
                        <!-- <form id="approveForm" action="{{ route('suratpesananbarang.approve', $suratpesananbarang->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                        <form id="rejectForm" action="{{ route('suratpesananbarang.reject', $suratpesananbarang->id) }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="catatan" value="Rejected by Finance">
                        </form> -->
                        @endif

                        <button onclick="window.print()" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->department === 'FNC' && $suratpesananbarang->status === 'pending')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmApprove() {
            Swal.fire({
                title: 'Approve Surat Pesanan?',
                text: "Apakah Anda yakin ingin menyetujui surat pesanan barang ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Approve!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approveForm').submit();
                }
            });
        }

        function confirmReject() {
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
                    document.getElementById('rejectForm').submit();
                }
            });
        }
    </script>
    @endif

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .max-w-9xl, .max-w-9xl * {
                visibility: visible;
            }
            .max-w-9xl {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            button, .bg-gray-500, .bg-green-500, .bg-blue-500, .bg-red-500, .bg-purple-500 {
                display: none !important;
            }
        }

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
            min-width: 1400px;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 0.75rem 0.5rem;
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
        .column-no { width: 50px; min-width: 50px; }
        .column-ukuran { width: 120px; min-width: 120px; }
        .column-product { width: 150px; min-width: 150px; }
        .column-brand { width: 120px; min-width: 120px; }
        .column-kw { width: 80px; min-width: 80px; }
        .column-jumlah { width: 100px; min-width: 100px; }
        .column-harga { width: 140px; min-width: 140px; }
        .column-disc { width: 100px; min-width: 100px; }
        .column-biaya { width: 140px; min-width: 140px; }
        .column-total { width: 120px; min-width: 120px; }
        .column-keterangan { width: 150px; min-width: 150px; }

        /* Styling untuk text alignment */
        .text-right {
            text-align: right;
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
                min-width: 1400px;
            }
        }
    </style>
</x-app-layout>