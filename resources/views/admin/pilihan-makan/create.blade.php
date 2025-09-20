@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Tambah pilihan makan santri</h3>
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
                        <a href="{{ route('pilihan-makan-santri.index') }}">Data pilihan makan santri</a>
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
                            <div class="card-title">Form Input pilihan makan santri</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom kiri -->
                                <form action="{{ route('pilihan-makan-santri.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group mb-3">
                                            <label>Santri</label>
                                            <select name="id_santri" class="form-control" required>
                                                <option value="">Pilih santri</option>
                                                @foreach ($santri as $s)
                                                    <option value="{{ $s->id_santri }}">{{ $s->nama_santri }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <!-- Kolom tengah -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="jenis_makan">Jenis Makan</label>
                                            <select name="jenis_makan" id="jenis_makan"
                                                class="form-control @error('jenis_makan') is-invalid @enderror">
                                                <option value="tidak_ambil"
                                                    {{ old('jenis_makan') == 'tidak_ambil' ? 'selected' : '' }}>Tidak Ambil
                                                </option>
                                                <option value="sehari_1x"
                                                    {{ old('jenis_makan') == 'sehari_1x' ? 'selected' : '' }}>Sehari 1x
                                                </option>
                                                <option value="sehari_2x"
                                                    {{ old('jenis_makan') == 'sehari_2x' ? 'selected' : '' }}>Sehari 2x
                                                </option>
                                            </select>
                                            @error('jenis_makan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('pilihan-makan-santri.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
@endsection
