@if($tagihan)
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>Laporan Tagihan Bulan {{ \Carbon\Carbon::create()->month($tagihan->bulan)->translatedFormat('F') }} {{ $tagihan->tahun }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Biaya Makan</th><td>Rp {{ number_format($tagihan->biaya_makan,0,',','.') }}</td></tr>
                <tr><th>Biaya Listrik</th><td>Rp {{ number_format($tagihan->biaya_listrik,0,',','.') }}</td></tr>
                <tr><th>Biaya Sosial</th><td>Rp {{ number_format($tagihan->biaya_sosial,0,',','.') }}</td></tr>
                <tr><th>Biaya Ianah</th><td>Rp {{ number_format($tagihan->biaya_ianah,0,',','.') }}</td></tr>
                <tr><th>Total Tagihan</th><td><strong>Rp {{ number_format($tagihan->total_tagihan,0,',','.') }}</strong></td></tr>
                <tr><th>Status Tagihan</th><td>{{ ucfirst($tagihan->status_tagihan) }}</td></tr>
            </table>

            <h6>Pembayaran:</h6>
            @if($tagihan->pembayaran->isEmpty())
                <p class="text-muted">Belum ada pembayaran.</p>
            @else
                <table class="table table-bordered">
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
        </div>
    </div>
@else
    <p class="text-danger">Data tagihan tidak ditemukan untuk bulan/tahun ini.</p>
@endif
