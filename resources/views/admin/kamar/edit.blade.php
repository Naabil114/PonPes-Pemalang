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
                <li class="nav-item"><a href="{{ route('kamar.index') }}">Data kamar</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">Edit</li>
            </ul>
        </div>

        <form action="{{ route('kamar.update', $kamar->id_kamar) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit Kamar</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="nama_kamar">nama_kamar</label>
                                        <input type="text" 
                                               name="nama_kamar" 
                                               class="form-control @error('nama_kamar') is-invalid @enderror" 
                                               value="{{ old('nama_kamar', $kamar->nama_kamar) }}">
                                        @error('nama_kamar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan">keterangan</label>
                                        <input type="text" 
                                               name="keterangan" 
                                               class="form-control @error('keterangan') is-invalid @enderror" 
                                               value="{{ old('keterangan', $kamar->keterangan) }}">
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                          <option value="aktif" {{ old('status', $kamar->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                          <option value="tidak_aktif" {{ old('status', $kamar->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                          
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('kamar.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
