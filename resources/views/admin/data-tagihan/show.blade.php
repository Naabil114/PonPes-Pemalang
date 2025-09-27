@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Detail Santri & Tagihan</h3>

            </div>
            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
            <br>


            {{-- Detail Santri --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Santri</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>NIS</th>
                            <td>{{ $santri->nis }}</td>
                        </tr>
                        <tr>
                            <th>Nama Santri</th>
                            <td>{{ $santri->nama_santri }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Madrasah</th>
                            <td>{{ $santri->madrasah->nama_madrasah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kamar</th>
                            <td>{{ $santri->kamar->nama_kamar ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ \Carbon\Carbon::parse($santri->tanggal_daftar)->translatedFormat('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Detail Tagihan --}}
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Data Tagihan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Bulan</th>
                                <th>Biaya Makan</th>
                                <th>Biaya Listrik</th>
                                <th>Biaya Sosial</th>
                                <th>Biaya Ianah</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penagihan as $p)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromDate($p->tahun, $p->bulan, 1)->translatedFormat('F Y') }}
                                    </td>
                                    <td>Rp {{ number_format($p->biaya_makan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($p->biaya_listrik, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($p->biaya_sosial, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($p->biaya_ianah, 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if ($p->status_tagihan == 'belum_bayar')
                                            <span class="badge bg-danger">Belum Bayar</span>
                                        @elseif ($p->status_tagihan == 'pending_verifikasi')
                                            <span class="badge bg-warning text-dark">Pending Verifikasi</span>
                                        @elseif ($p->status_tagihan == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif ($p->status_tagihan == 'terlambat')
                                            <span class="badge bg-secondary">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
