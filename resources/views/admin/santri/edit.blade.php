@extends('layouts.index')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Santri</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('santri.index') }}">Data Santri</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">Edit</li>
            </ul>
        </div>

        <form action="{{ route('santri.update', $santri->id_santri) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit Santri</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" 
                                               name="username" 
                                               class="form-control @error('username') is-invalid @enderror" 
                                               value="{{ old('username', $santri->user->username) }}">
                                        <input type="hidden" name="user_id" value="{{ $santri->user->id }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password (Kosongkan jika tidak diganti)</label>
                                        <input type="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_orang_tua">Nama Orang Tua</label>
                                        <input type="text" 
                                               name="nama_orang_tua" 
                                               class="form-control @error('nama_orang_tua') is-invalid @enderror" 
                                               value="{{ old('nama_orang_tua', $santri->nama_orang_tua) }}">
                                        @error('nama_orang_tua')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="id_madrasah">Madrasah</label>
                                        <select name="id_madrasah" class="form-control @error('id_madrasah') is-invalid @enderror">
                                            <option value="">-- Pilih Madrasah --</option>
                                            @foreach ($madrasah as $m)
                                                <option value="{{ $m->id_madrasah }}" {{ old('id_madrasah', $santri->id_madrasah) == $m->id_madrasah ? 'selected' : '' }}>
                                                    {{ $m->nama_madrasah }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_madrasah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kolom tengah -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="nama_santri">Nama Santri</label>
                                        <input type="text" 
                                               name="nama_santri" 
                                               class="form-control @error('nama_santri') is-invalid @enderror" 
                                               value="{{ old('nama_santri', $santri->nama_santri) }}">
                                        @error('nama_santri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" 
                                               name="tempat_lahir" 
                                               class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                               value="{{ old('tempat_lahir', $santri->tempat_lahir) }}">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="no_telp">No Telp Ortu</label>
                                        <input type="number" 
                                               name="no_telp" 
                                               class="form-control @error('no_telp') is-invalid @enderror" 
                                               value="{{ old('no_telp', $santri->no_telp) }}">
                                        @error('no_telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="id_kamar">Kamar</label>
                                        <select name="id_kamar" class="form-control @error('id_kamar') is-invalid @enderror">
                                            <option value="">-- Pilih Kamar --</option>
                                            @foreach ($kamar as $k)
                                                <option value="{{ $k->id_kamar }}" {{ old('id_kamar', $santri->id_kamar) == $k->id_kamar ? 'selected' : '' }}>
                                                    {{ $k->nama_kamar }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kamar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kolom kanan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" 
                                               name="tanggal_lahir" 
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Kelamin</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="jenis_kelamin" 
                                                   value="L" 
                                                   {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="jenis_kelamin" 
                                                   value="P" 
                                                   {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label">Perempuan</label>
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" 
                                                  class="form-control @error('alamat') is-invalid @enderror" 
                                                  rows="4">{{ old('alamat', $santri->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="status_santri">Status Santri</label>
                                        <select name="status_santri" class="form-control @error('status_santri') is-invalid @enderror">
                                            <option value="pendaftar" {{ old('status_santri', $santri->status_santri) == 'pendaftar' ? 'selected' : '' }}>Pendaftar</option>
                                            <option value="aktif" {{ old('status_santri', $santri->status_santri) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="alumni" {{ old('status_santri', $santri->status_santri) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                            <option value="keluar" {{ old('status_santri', $santri->status_santri) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                        </select>
                                        @error('status_santri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('santri.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
