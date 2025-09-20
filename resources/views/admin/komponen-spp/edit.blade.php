@extends('layouts.index')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h4>Edit Komponen SPP</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('komponen_spp.update', $data->id_komponen) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-lg-4">
                    <div class="form-group mb-3">
                        <label>Madrasah</label>
                        <select name="id_madrasah" class="form-control" required>
                            @foreach($madrasah as $m)
                                <option value="{{ $m->id_madrasah }}" {{ $m->id_madrasah == $data->id_madrasah ? 'selected' : '' }}>
                                    {{ $m->nama_madrasah }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Komponen</label>
                        <input type="text" name="nama_komponen" value="{{ $data->nama_komponen }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" value="{{ $data->harga }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="makan" {{ $data->kategori == 'makan' ? 'selected' : '' }}>Makan</option>
                            <option value="listrik" {{ $data->kategori == 'listrik' ? 'selected' : '' }}>Listrik</option>
                            <option value="sosial" {{ $data->kategori == 'sosial' ? 'selected' : '' }}>Sosial</option>
                            <option value="ianah" {{ $data->kategori == 'ianah' ? 'selected' : '' }}>I'anah</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ $data->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('komponen_spp.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
