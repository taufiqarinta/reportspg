<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pesanan Barang - {{ $suratpesananbarang->nomor_surat }}</title>
    <style>
        
        body { 
            position: relative;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        .footer-note {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #666;
            font-size: 8px;
            color: #333;
        }
        
        .header-company {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .company-details {
            margin-bottom: 2px;
            font-size: 9px;
            color: #333;
        }
        .document-header {
            text-align: center;
            margin: 15px 0;
        }
        .document-title {
            font-size: 14px;
            font-weight: bold;
        }
        .document-number {
            font-size: 12px;
            font-weight: bold;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            font-size: 9px;
        }
        .table th, .table td { 
            border: 1px solid #000; 
            padding: 5px; 
        }
        .table th { 
            background-color: #f0f0f0; 
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .signature { 
            margin-top: 40px; 
        }
        .signature-table { 
            width: 100%; 
        }
        .signature-table td { 
            width: 50%; 
            text-align: center; 
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 3px;
        }
        .footer-note {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #666;
            font-size: 8px;
            color: #333;
        }
        .note-list {
            margin: 0;
            padding-left: 12px;
        }
        .note-list li {
            margin-bottom: 2px;
            line-height: 1.2;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9px;
        }
        .info-table td {
            padding: 3px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 80px;
        }
    </style>
</head>
<body>
    <!-- Header Perusahaan -->
    <div class="header-company">
        <div class="company-name">PT MEGA INSPIRASI SUMBER SEJAHTERA</div>
        <div class="company-details">
            Jl. Gunung Sahari Raya Komp Mangga Dua Square G-22
        </div>
        <div class="company-details mt-2">
            Telp : (021) 62310108 (Hunting) | Telp : (021) 62312550
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
            <td class="info-label">Pengirim:</td>
            <td>{{ $suratpesananbarang->pengirim }}</td>
            <td class="info-label">Penerima:</td>
            <td>{{ $suratpesananbarang->penerima }}</td>
        </tr>
        <tr>
            <td class="info-label">Tanggal Surat:</td>
            <td>{{ $suratpesananbarang->tanggal_surat->format('d/m/Y') }}</td>
            <td class="info-label">Tanggal Kirim:</td>
            <td>{{ $suratpesananbarang->tanggal_kirim->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="info-label">Pemesan:</td>
            <td>{{ $suratpesananbarang->pemesan ?? '-' }}</td>
            <td class="info-label">Status:</td>
            <td><strong>{{ strtoupper($suratpesananbarang->status) }}</strong></td>
        </tr>
    </table>

    <!-- Detail Barang -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Product</th>
                <th>KW</th>
                <th>Jumlah/Box</th>
                <th>Harga</th>
                <th>Disc</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratpesananbarang->details as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail->kode }}</td>
                <td>{{ $detail->nama_product }}</td>
                <td class="text-center">{{ $detail->kw ?? '-' }}</td>
                <td class="text-right">{{ number_format($detail->jumlah_box, 2) }}</td>
                <td class="text-right">{{ number_format($detail->harga_satuan_box, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->disc, 2) }}%</td>
                <td class="text-right">{{ number_format($detail->total_rp, 0, ',', '.') }}</td>
                <td>{{ $detail->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($suratpesananbarang->total_keseluruhan, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong></strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature">
        <table class="signature-table">
            <tr>
                <td style="width: 50%; text-align: center; padding: 0 20px;">
                    <div style="margin-bottom: 60px;">
                        <p><strong>Sales</strong></p>
                    </div>
                    <div style="border-top: 1px solid #000; padding-top: 3px;">
                        <p>{{ $suratpesananbarang->creator->name ?? '-' }}</p>
                    </div>
                </td>
                <td style="width: 50%; text-align: center; padding: 0 20px;">
                    <div style="margin-bottom: 60px;">
                        @if($suratpesananbarang->status === 'rejected')
                            <p><strong>Ditolak</strong></p>
                        @else
                            <p><strong>Disetujui</strong></p>
                        @endif
                    </div>
                    <div style="border-top: 1px solid #000; padding-top: 3px;">
                        <p>{{ $suratpesananbarang->approver->name ?? '-' }}</p>
                    </div>
                </td>
            </tr>
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
</body>
</html>