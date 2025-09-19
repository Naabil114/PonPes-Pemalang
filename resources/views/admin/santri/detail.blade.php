@extends('layouts.index')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Detail Santri</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('santri.index') }}">Data Santri</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">Detail</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Informasi Lengkap Santri</h4>
                    </div>
                    <div class="card-body">

                        <!-- Informasi Santri -->
                        <div class="mb-4">
                            <h5 class="text-muted">Data Pribadi</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>NIS:</strong>
                                    <p>{{ $santri->nis ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Nama Santri:</strong>
                                    <p>{{ $santri->nama_santri }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Tempat Lahir:</strong>
                                    <p>{{ $santri->tempat_lahir }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Tanggal Lahir:</strong>
                                    <p>{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Jenis Kelamin:</strong>
                                    <p>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Status Santri:</strong>
                                    @if ($santri->status_santri == 'pendaftar')
                                        <span class="badge bg-secondary">Pendaftar</span>
                                    @elseif ($santri->status_santri == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif ($santri->status_santri == 'alumni')
                                        <span class="badge bg-info">Alumni</span>
                                    @elseif ($santri->status_santri == 'keluar')
                                        <span class="badge bg-danger">Keluar</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Keluarga -->
                        <div class="mb-4">
                            <h5 class="text-muted">Data Orang Tua</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Nama Orang Tua:</strong>
                                    <p>{{ $santri->nama_orang_tua }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>No Telepon:</strong>
                                    <p>{{ $santri->no_telp }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Alamat:</strong>
                                    <p>{{ $santri->alamat }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pendidikan & Kamar -->
                        <div class="mb-4">
                            <h5 class="text-muted">Pendidikan & Kamar</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Kelas / Madrasah:</strong>
                                    <p>{{ $santri->madrasah->nama_madrasah ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Kamar:</strong>
                                    <p>{{ $santri->kamar->nama_kamar ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Tanggal Daftar:</strong>
                                    <p>{{ \Carbon\Carbon::parse($santri->tanggal_daftar)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Aksi -->
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('santri.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <div>
                                <a href="{{ route('santri.edit', $santri->id_santri) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('santri.destroy', $santri->id_santri) }}" 
                                      method="POST" 
                                      class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
