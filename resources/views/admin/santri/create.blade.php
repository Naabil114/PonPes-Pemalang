@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Tambah Santri</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('santri.index') }}">Data Santri</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">Tambah</li>
                </ul>
            </div>

            <form action="{{ route('santri.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Form Input Santri</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kolom kiri -->
                                    <form action="{{ route('santri.store') }}" method="POST">
                                        @csrf
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">password</label>
                                                <input type="text" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    value="{{ old('password') }}">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_orang_tua">Nama orang tua</label>
                                                <input type="text" name="nama_orang_tua"
                                                    class="form-control @error('nama_orang_tua') is-invalid @enderror"
                                                    value="{{ old('nama_orang_tua') }}">
                                                @error('nama_orang_tua')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- Tambahan Pilih madrasah -->
                                            <div class="form-group">
                                                <label for="id_madrasah">Madrasah</label>
                                                <select name="id_madrasah"
                                                    class="form-control @error('id_madrasah') is-invalid @enderror">
                                                    <option value="">-- Pilih Madrasah --</option>
                                                    @foreach ($madrasah as $m)
                                                        <option value="{{ $m->id_madrasah }}"
                                                            {{ old('id_madrasah') == $m->id_madrasah ? 'selected' : '' }}>
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
                                                <label for="nama_santri">Nama santri</label>
                                                <input type="text" name="nama_santri"
                                                    class="form-control @error('nama_santri') is-invalid @enderror"
                                                    value="{{ old('nama_santri') }}">
                                                @error('nama_santri')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tempat_lahir">Tempat lahir</label>
                                                <input type="text" name="tempat_lahir"
                                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                    value="{{ old('tempat_lahir') }}">
                                                @error('tempat_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telp">No telp ortu</label>
                                                <input type="number" name="no_telp"
                                                    class="form-control @error('no_telp') is-invalid @enderror"
                                                    value="{{ old('no_telp') }}">
                                                @error('no_telp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- Tambahan Pilih Kamar -->
                                            <div class="form-group">
                                                <label for="id_kamar">Kamar</label>
                                                <select name="id_kamar"
                                                    class="form-control @error('id_kamar') is-invalid @enderror">
                                                    <option value="">-- Pilih Kamar --</option>
                                                    @foreach ($kamar as $k)
                                                        <option value="{{ $k->id_kamar }}"
                                                            {{ old('id_kamar') == $k->id_kamar ? 'selected' : '' }}>
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
                                                <label for="tanggal_lahir">Tanggal lahir</label>
                                                <input type="date" name="tanggal_lahir"
                                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                    value="{{ old('tanggal_lahir') }}">
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                        value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Laki-Laki</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                        value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Perempuan</label>
                                                </div>
                                                @error('jenis_kelamin')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4">{{ old('alamat') }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ route('santri.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
            </form>
        </div>
    </div>
    </div>
    </form>
    </div>
    </div>
@endsection
