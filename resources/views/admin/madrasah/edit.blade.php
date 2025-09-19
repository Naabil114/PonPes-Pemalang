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
                <li class="nav-item"><a href="{{ route('madrasah.index') }}">Data madrasah</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">Edit</li>
            </ul>
        </div>

        <form action="{{ route('madrasah.update', $madrasah->id_madrasah) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit madrasah</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="nama_madrasah">Nama madrasah</label>
                                        <input type="text" 
                                               name="nama_madrasah" 
                                               class="form-control @error('nama_madrasah') is-invalid @enderror" 
                                               value="{{ old('nama_madrasah', $madrasah->nama_madrasah) }}">
                                        @error('nama_madrasah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <input type="text" 
                                               name="deskripsi" 
                                               class="form-control @error('deskripsi') is-invalid @enderror" 
                                               value="{{ old('deskripsi', $madrasah->deskripsi) }}">
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                          <option value="aktif" {{ old('status', $madrasah->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                          <option value="tidak_aktif" {{ old('status', $madrasah->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                          
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
                            <a href="{{ route('madrasah.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
