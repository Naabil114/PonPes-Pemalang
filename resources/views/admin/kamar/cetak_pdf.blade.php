<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kamar {{ $kamar->nama_kamar }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .rekap {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Laporan Kamar: {{ $kamar->nama_kamar }}</h2>
    <p>Total Santri: {{ $kamar->santri->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Pilihan Makan</th>
                <th>Total Tagihan</th>
                <th>Status Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTagihanKamar = 0;
            @endphp
            @foreach ($kamar->santri as $index => $santri)
                @php
                    $tagihanSantri = $santri->tagihanSpp->sum('total_tagihan');
                    $totalTagihanKamar += $tagihanSantri;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $santri->nama_santri }}</td>
                    <td>{{ $santri->pilihanMakanTerbaru->jenis_makan ?? 'Belum dipilih' }}</td>
                    <td>Rp {{ number_format($tagihanSantri, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $statusTagihan = $santri->tagihanSpp->last()->status_tagihan ?? null;
                        @endphp

                        @if ($statusTagihan === 'belum_bayar')
                            <span style="color:red; font-weight:bold;">Belum Bayar</span>
                        @elseif ($statusTagihan === 'pending_verifikasi')
                            <span style="color:orange; font-weight:bold;">Menunggu Verifikasi</span>
                        @elseif ($statusTagihan === 'lunas')
                            <span style="color:green; font-weight:bold;">Lunas</span>
                        @else
                            <span style="color:gray;">-</span>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="rekap">
        Total Tagihan Kamar {{ $kamar->nama_kamar }} :
        Rp {{ number_format($totalTagihanKamar, 0, ',', '.') }}
    </p>
</body>

</html>
