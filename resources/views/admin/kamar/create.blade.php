@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Tambah Kamar</h3>
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
                        <a href="{{ route('santri.index') }}">Data Kamar</a>
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
                            <div class="card-title">Form Input Kamar</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <form action="{{ route('kamar.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="nama_kamar">Nama kamar</label>
                                            <input type="text" name="nama_kamar"
                                                class="form-control @error('nama_kamar') is-invalid @enderror"
                                                value="{{ old('nama_kamar') }}">
                                            @error('nama_kamar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <!-- Kolom tengah -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" name="keterangan"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                value="{{ old('keterangan') }}">
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('kamar.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
