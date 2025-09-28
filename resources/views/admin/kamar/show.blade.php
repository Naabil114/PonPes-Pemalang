@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex align-items-center justify-content-between">
                <h3 class="fw-bold mb-3">Detail Kamar: {{ $kamar->nama_kamar }}</h3>

                <a href="{{ route('kamar.cetakPdf', $kamar->id_kamar) }}" target="_blank" class="btn btn-danger">
                    Cetak PDF
                </a>
            </div>


            <div class="card mb-3">
                <div class="card-body">
                    <h5>Informasi Kamar</h5>
                    <p><strong>Nama Kamar:</strong> {{ $kamar->nama_kamar }}</p>
                    <p><strong>Keterangan:</strong> {{ $kamar->keterangan }}</p>
                    <p><strong>Status:</strong>
                        @if ($kamar->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h5>Daftar Santri di Kamar Ini</h5>
                    @forelse($kamar->santri as $santri)
                        <div class="border rounded p-3 mb-3">
                            <p><strong>Nama:</strong> {{ $santri->nama_santri }}</p>
                            <p><strong>Pilihan Makan:</strong>
                                {{ $santri->pilihanMakanTerbaru->jenis_makan ?? 'Belum dipilih' }}
                            </p>

                            <h6>Tagihan SPP:</h6>
                            <ul>
                                @forelse($santri->tagihanSpp as $tagihan)
                                    <li>
                                        Bulan {{ $tagihan->bulan }} -
                                        Rp{{ number_format($tagihan->total_tagihan, 0, ',', '.') }}
                                        @if ($tagihan->status_tagihan == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-warning">Belum Lunas</span>
                                        @endif
                                    </li>
                                @empty
                                    <li>Tidak ada tagihan</li>
                                @endforelse
                            </ul>
                        </div>
                    @empty
                        <p>Tidak ada santri di kamar ini.</p>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
