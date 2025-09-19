@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Tambah madrasah</h3>
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
                        <a href="{{ route('madrasah.index') }}">Data madrasah</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">Tambah</li>
                </ul>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Input madrasah</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <form action="{{ route('madrasah.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="nama_madrasah">Nama madrasah</label>
                                            <input type="text" name="nama_madrasah"
                                                class="form-control @error('nama_madrasah') is-invalid @enderror"
                                                value="{{ old('nama_madrasah') }}">
                                            @error('nama_madrasah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <!-- Kolom tengah -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <input type="text" name="deskripsi"
                                                class="form-control @error('deskripsi') is-invalid @enderror"
                                                value="{{ old('deskripsi') }}">
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('madrasah.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
