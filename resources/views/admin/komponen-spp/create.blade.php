@extends('layouts.index')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Komponen SPP</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('komponen_spp.store') }}" method="POST">
                    @csrf
                    <div class="col-md-6 col-lg-4">
                    <div class="form-group mb-3">
                        <label>Madrasah</label>
                        <select name="id_madrasah" class="form-control" required>
                            <option value="">Pilih Madrasah</option>
                            @foreach($madrasah as $m)
                                <option value="{{ $m->id_madrasah }}">{{ $m->nama_madrasah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Komponen</label>
                        <input type="text" name="nama_komponen" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="makan">Makan</option>
                            <option value="listrik">Listrik</option>
                            <option value="sosial">Sosial</option>
                            <option value="ianah">I'anah</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('komponen_spp.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
