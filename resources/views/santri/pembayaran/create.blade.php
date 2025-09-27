@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Form Pembayaran SPP</h3>
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
                        <a href="{{ route('penagihan-santri.index') }}">Data Tagihan</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Pembayaran</a>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-8 offset-md-2">
                    @forelse ($rekening as $rek)
                        <div class="col-md-6 offset-md-3 mb-4">
                            <div class="card card-secondary bg-secondary-gradient">
                                <div class="card-body skew-shadow">
                                    <img src="{{ asset('assets/img/visa.svg') }}" height="12.5" alt="Visa Logo" />
                                    <h2 class="py-4 mb-0">{{ $rek->jenis_bank }} : {{ $rek->no_rek }} </h2>
                                    <div class="row">
                                        <div class="col-8 pe-0">
                                            <h3 class="fw-bold mb-1">{{ $rek->nama_rek }}</h3>
                                            <div class="text-small text-uppercase fw-bold op-8">
                                                Transfer ke sini
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            @empty
                @endforelse
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Pembayaran Tagihan Bulan
                            {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('santri.pembayaran.store', $tagihan->id_tagihan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Jumlah Bayar --}}
                            <div class="mb-3">
                                <label class="form-label">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar"
                                    class="form-control @error('jumlah_bayar') is-invalid @enderror" readonly
                                    value="{{ old('jumlah_bayar', $tagihan->total_tagihan) }}" required>
                                @error('jumlah_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bank Pengirim --}}
                            <div class="mb-3">
                                <label class="form-label">Bank Pengirim</label>
                                <input type="text" name="bank_pengirim"
                                    class="form-control @error('bank_pengirim') is-invalid @enderror"
                                    value="{{ old('bank_pengirim') }}" required>
                                @error('bank_pengirim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Pengirim --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Pengirim</label>
                                <input type="text" name="nama_pengirim"
                                    class="form-control @error('nama_pengirim') is-invalid @enderror"
                                    value="{{ old('nama_pengirim') }}" required>
                                @error('nama_pengirim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bukti Pembayaran --}}
                            <div class="mb-3">
                                <label class="form-label">Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran"
                                    class="form-control @error('bukti_pembayaran') is-invalid @enderror">
                                @error('bukti_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('santri.tagihan.show', $tagihan->id_santri) }}"
                                    class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    showClass: {
                        popup: `
                    animate__animated
                    animate__fadeInUp
                    animate__faster
                `
                    },
                    hideClass: {
                        popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                `
                    }
                });
            });
        </script>
    @endif
