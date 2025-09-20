@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Edit pilihan makan santri</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('pilihan-makan-santri.index') }}">Data pilihan makan santri</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">Edit</li>

                </ul>
            </div>

            <form action="{{ route('pilihan-makan-santri.update', $data->id_pilihan_makan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          
                            <div class="card-header">
                                <div class="card-title">Form Edit</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kolom kiri -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group mb-3">
                                            <label>Santri</label>
                                            <input type="text" value="{{ $data->santri->nama_santri }}" class="form-control" readonly>
                                            <input type="hidden" name="id_santri" value="{{ $data->id_santri }}">
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="jenis_makan">jenis_makan</label>
                                            <select name="jenis_makan"
                                                class="form-control @error('jenis_makan') is-invalid @enderror">
                                                <option value="tidak_ambil"
                                                    {{ old('jenis_makan', $data->jenis_makan) == 'tidak_ambil' ? 'selected' : '' }}>
                                                    Tidak Ambil
                                                </option>
                                                <option value="sehari_1x"
                                                    {{ old('jenis_makan', $data->jenis_makan) == 'sehari_1x' ? 'selected' : '' }}>
                                                    Sehari 1x
                                                </option>
                                                <option value="sehari_2x"
                                                    {{ old('jenis_makan', $data->jenis_makan) == 'sehari_2x' ? 'selected' : '' }}>
                                                    Sehari 2x
                                                </option>

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
                                <a href="{{ route('pilihan-makan-santri.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
