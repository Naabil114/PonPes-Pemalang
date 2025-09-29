@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Detail Pendaftaran Santri</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('pendaftaran.index') }}">Konfirmasi Pendaftaran</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Detail</a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Santri</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>NIS</th>
                                    <td>{{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Santri</th>
                                    <td>{{ $santri->nama_santri }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>{{ $santri->tempat_lahir }}, {{ $santri->tanggal_lahir }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Orang Tua</th>
                                    <td>{{ $santri->nama_orang_tua }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $santri->no_telp }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $santri->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($santri->status_santri == 'pendaftar')
                                            <span class="badge bg-warning text-dark">Pendaftar</span>
                                        @elseif ($santri->status_santri == 'diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif ($santri->status_santri == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Berkas Upload</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Foto:
                                    Pas Foto:
                                    @if ($santri->berkas && $santri->berkas->file_pas_foto)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_pas_foto) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    KK:
                                    @if ($santri->berkas && $santri->berkas->file_kk)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_kk) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    Akta Kelahiran:
                                    @if ($santri->berkas && $santri->berkas->file_akta_kelahiran)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_akta_kelahiran) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    Ijazah SD:
                                    @if ($santri->berkas && $santri->berkas->file_ijazah_sd)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_ijazah_sd) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    SKHU SD:
                                    @if ($santri->berkas && $santri->berkas->file_skhu_sd)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_skhu_sd) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    Pas Foto:
                                    @if ($santri->berkas && $santri->berkas->file_pas_foto)
                                        <a href="{{ asset('storage/' . $santri->berkas->file_pas_foto) }}"
                                            target="_blank">Download</a>
                                    @else
                                        Tidak ada
                                    @endif
                            </ul>

                            <div class="mt-4">
                                <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div> <!-- card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
