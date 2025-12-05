<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pesanan Barang - {{ $suratpesananbarang->nomor_surat }}</title>
    <style>
        @page {
            size: A5 landscape;
            margin: 0.5cm;
        }
        
        body { 
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 9px;
            position: relative;
        }
        
        .page-container {
            position: relative;
            min-height: 100vh;
        }
        
        .content-wrap {
            padding-bottom: 120px; /* Space for footer */
        }
        
        .footer-section {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        
        .header-company {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .logo-container {
            flex: 0 0 auto;
            margin-right: 10px;
        }
        .company-logo {
            max-width: 120px;
            max-height: 120px;
        }
        .company-info {
            flex: 1;
            text-align: center;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-details {
            margin-bottom: 1px;
            font-size: 8px;
            color: #333;
        }
        .document-header {
            text-align: center;
            margin: 10px 0;
        }
        .document-title {
            font-size: 12px;
            font-weight: bold;
        }
        .document-number {
            font-size: 10px;
            font-weight: bold;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 10px; 
            font-size: 10px;
        }
        .table th, .table td { 
            border: 1px solid #000; 
            padding: 2px; 
        }
        .table th { 
            background-color: #f0f0f0; 
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .signature { 
            margin-top: 10px; 
        }
        .signature-table { 
            width: 100%; 
            border-collapse: collapse;
            border: 1px solid #666;
            font-size: 8px;
            text-align: center;
        }
        .signature-table th,
        .signature-table td {
            border: 1px solid #666;
            padding: 3px;
        }
        .signature-table th {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .footer-note {
            margin-top: 8px;
            padding-top: 5px;
            border-top: 1px solid #666;
            font-size: 7px;
            color: #333;
        }
        .note-list {
            margin: 0;
            padding-left: 10px;
        }
        .note-list li {
            margin-bottom: 1px;
            line-height: 1.1;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 10px;
            table-layout: fixed;
        }
        .info-table td {
            padding: 2px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .info-value-left {
            width: 30%;
        }
        .info-label-right {
            font-weight: bold;
            width: 120px;
        }
        .info-value-right {
            width: calc(50% - 240px);
        }
        
        /* Kolom table */
        .column-no { width: 3%; }
        .column-ukuran { width: 4%; }
        .column-product { width: 10%; }
        .column-brand { width: 6%; }
        .column-kw { width: 4%; }
        .column-jumlah { width: 4%; }
        .column-harga { width: 6%; }
        .column-disc { width: 6%; }
        .column-biaya { width: 8%; }
        .column-total { width: 8%; }
        .column-keterangan { width: 10%; }
        
        /* CSS untuk pagination */
        .page-break {
            page-break-after: always;
        }
        thead { 
            display: table-header-group; 
        }
        tfoot { 
            display: table-footer-group; 
        }
        
        /* Compact styling untuk menghemat ruang */
        .compact-row {
            line-height: 1.2;
        }
        .small-text {
            font-size: 8px;
        }
    </style>
</head>
<body>
    <?php
        $max_per_halaman = 5;
        $total_baris = count($suratpesananbarang->details);
        $total_halaman = ceil($total_baris / $max_per_halaman);
    ?>

    @for($halaman = 0; $halaman < $total_halaman; $halaman++)
        <div class="page-container">
            <div class="content-wrap">
                <!-- Header Perusahaan dengan Logo -->
                <div class="header-company">
                    <div class="logo-container">
                        <img src="{{ storage_path('app/public/logo-pt-mega.jpg') }}" class="company-logo" alt="PT MEGA INSPIRASI SUMBER SEJAHTERA">
                    </div>
                    <div class="company-info">
                        <div class="company-name">PT MEGA INSPIRASI SUMBER SEJAHTERA</div>
                        <div class="company-details">
                            Jl. Gunung Sahari Raya Komp Mangga Dua Square G-22
                        </div>
                        <div class="company-details">
                            Telp : (021) 62310108 (Hunting) | Telp : (021) 62312550
                        </div>
                    </div>
                </div>

                <!-- Header Dokumen -->
                <div class="document-header">
                    <div class="document-title">SURAT PESANAN BARANG</div>
                    <div class="document-number">No: {{ $suratpesananbarang->nomor_surat }}</div>
                </div>

                <!-- Informasi Surat -->
                <table class="info-table">
                    <tr>
                        <td class="info-label">Pesanan Dari:</td>
                        <td class="info-value-left">{{ $suratpesananbarang->pengirim }}</td>
                        <td class="info-label-right">Nama Sales:</td>
                        <td class="info-value-right">{{ $suratpesananbarang->penerima }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tanggal Surat:</td>
                        <td class="info-value-left">{{ $suratpesananbarang->tanggal_surat->format('d/m/Y') }}</td>
                        <td class="info-label-right">Tanggal Kirim:</td>
                        <td class="info-value-right">{{ $suratpesananbarang->tanggal_kirim->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Dikirim Ke:</td>
                        <td class="info-value-left">{{ $suratpesananbarang->dikirim_ke ?? '-' }}</td>
                        <td class="info-label">Status:</td>
                        <td class="info-value-right">
                            @if($suratpesananbarang->status === 'pending')
                                <strong style="color: #eab308;">{{ strtoupper($suratpesananbarang->status) }}</strong>
                            @elseif($suratpesananbarang->status === 'rejected')
                                <strong style="color: #dc2626;">{{ strtoupper($suratpesananbarang->status) }}</strong>
                            @elseif($suratpesananbarang->status === 'diketahui')
                                <strong style="color: #16a34a;">Approved by SLS</strong>
                            @elseif($suratpesananbarang->status === 'approved')
                                <strong style="color: #16a34a;">{{ strtoupper($suratpesananbarang->status) }}</strong>
                            @else
                                <strong>{{ strtoupper($suratpesananbarang->status) }}</strong>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Detail Barang -->
                <table class="table">
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
                        @php
                            $start_index = $halaman * $max_per_halaman;
                            $end_index = min(($halaman + 1) * $max_per_halaman, $total_baris);
                        @endphp
                        
                        @for($i = $start_index; $i < $end_index; $i++)
                            @php
                                $detail = $suratpesananbarang->details[$i];
                            @endphp
                            <tr class="compact-row">
                                <td class="column-no text-center">{{ $i + 1 }}</td>
                                <td class="column-ukuran text-center">{{ $detail->ukuran ?? '-' }}</td>
                                <td class="column-product small-text">{{ $detail->nama_product }}</td>
                                <td class="column-brand">{{ $detail->brand ?? '-' }}</td>
                                <td class="column-kw text-center">{{ $detail->kw ?? '-' }}</td>
                                <td class="column-jumlah text-center">{{ number_format($detail->jumlah_box, 0, '.', '.') }}</td>
                                <td class="column-harga text-right">Rp {{ number_format($detail->harga_satuan_box, 2, ',', '.') }}</td>
                                <td class="column-disc text-right">Rp {{ number_format($detail->disc, 2, ',', '.') }}</td>
                                <td class="column-biaya text-right">Rp {{ number_format($detail->biaya_tambahan_ekspedisi, 2, ',', '.') }}</td>
                                <td class="column-total text-right">Rp {{ number_format($detail->total_rp, 2, ',', '.') }}</td>
                                <td class="column-keterangan small-text">{{ $detail->keterangan ?? '-' }}</td>
                            </tr>
                        @endfor
                        
                        <!-- Tambahkan baris kosong jika kurang dari max_per_halaman -->
                        @for($i = $end_index; $i < ($halaman + 1) * $max_per_halaman; $i++)
                            <tr class="compact-row">
                                <td class="column-no text-center">&nbsp;</td>
                                <td class="column-ukuran text-center">&nbsp;</td>
                                <td class="column-product">&nbsp;</td>
                                <td class="column-brand">&nbsp;</td>
                                <td class="column-kw text-center">&nbsp;</td>
                                <td class="column-jumlah text-center">&nbsp;</td>
                                <td class="column-harga text-right">&nbsp;</td>
                                <td class="column-disc text-right">&nbsp;</td>
                                <td class="column-biaya text-right">&nbsp;</td>
                                <td class="column-total text-right">&nbsp;</td>
                                <td class="column-keterangan">&nbsp;</td>
                            </tr>
                        @endfor
                        
                        <!-- Total hanya di halaman terakhir -->
                        @if($halaman == $total_halaman - 1)
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-right font-bold border">Total Keseluruhan:</td>
                                <td class="column-jumlah text-center font-bold">{{ number_format($suratpesananbarang->total_jumlahbox, 0, ',', '.') }}</td>
                                <td colspan="3"></td>
                                <td class="column-total text-right font-bold">Rp {{ number_format($suratpesananbarang->total_keseluruhan, 0, ',', '.') }}</td>
                                <td class="column-keterangan"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Footer Section (Signature dan Notes) -->
            <div class="footer-section">
                <!-- Tanda Tangan -->
                <div class="signature">
                    <table class="signature-table">
                        <thead>
                            <tr>
                                <th style="width: 33.33%;">Sales</th>
                                @if($suratpesananbarang->status === 'rejected')
                                    <th style="width: 33.33%;">Ditolak</th>
                                @else
                                    <th style="width: 33.33%;">Disetujui</th>
                                @endif
                                <th style="width: 33.33%;">Pesanan Dari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="height: 60px; vertical-align: bottom;">
                                    {{ $suratpesananbarang->pengirim ?? '-' }}
                                </td>
                                <td style="height: 60px; vertical-align: bottom;">
                                    {{ $suratpesananbarang->approver->name ?? '-' }}
                                </td>
                                <td style="height: 60px; vertical-align: bottom;">
                                    {{ $suratpesananbarang->pemesan ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Note -->
                <div class="footer-note">
                    <ol class="note-list">
                        <li>Surat Pesanan Barang bukan merupakan tanda terima pembayaran & bukan untuk Pengambilan Barang</li>
                        <li>Harga tidak mengikat, sebelum adanya pembayaran</li>
                        <li>Pembayaran dengan Transfer atau BG/Cek Cross atas nama PT Mega Inspirasi Sumber Sejahtera</li>
                        <li>BG/Cek yang belum dicairkan, belum dianggap lunas</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Page Break untuk halaman berikutnya (kecuali halaman terakhir) -->
        @if($halaman < $total_halaman - 1)
            <div style="page-break-after: always;"></div>
        @endif
    @endfor
</body>
</html>