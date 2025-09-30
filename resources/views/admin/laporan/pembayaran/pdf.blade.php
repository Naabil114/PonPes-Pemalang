<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Laporan Pembayaran Santri</h2>
    <p><strong>Nama Santri:</strong> {{ $tagihan->santri->nama_santri }}</p>
    <p><strong>NIS:</strong> {{ $tagihan->santri->nis }}</p>
    <p><strong>Bulan/Tahun:</strong> 
        {{ \Carbon\Carbon::create()->month($tagihan->bulan)->translatedFormat('F') }} {{ $tagihan->tahun }}
    </p>

    <h4>Detail Tagihan</h4>
    <table>
        <tr><th>Biaya Makan</th><td>Rp {{ number_format($tagihan->biaya_makan,0,',','.') }}</td></tr>
        <tr><th>Biaya Listrik</th><td>Rp {{ number_format($tagihan->biaya_listrik,0,',','.') }}</td></tr>
        <tr><th>Biaya Sosial</th><td>Rp {{ number_format($tagihan->biaya_sosial,0,',','.') }}</td></tr>
        <tr><th>Biaya Ianah</th><td>Rp {{ number_format($tagihan->biaya_ianah,0,',','.') }}</td></tr>
        <tr><th>Total</th><td><strong>Rp {{ number_format($tagihan->total_tagihan,0,',','.') }}</strong></td></tr>
        <tr><th>Status</th><td>{{ ucfirst($tagihan->status_tagihan) }}</td></tr>
    </table>

    <h4 style="margin-top:20px">Detail Pembayaran</h4>
    @if($tagihan->pembayaran->isEmpty())
        <p>Belum ada pembayaran.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihan->pembayaran as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar,0,',','.') }}</td>
                    <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                    <td>{{ ucfirst($p->status_verifikasi) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
