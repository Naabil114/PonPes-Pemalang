@extends('layouts.index')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Detail Santri & Tagihan</h3>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-3 d-flex justify-content-end gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <br>

        <div class="row">
            <!-- Data Santri -->
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Santri</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <th style="width: 40%">NIS</th>
                                    <td>{{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Santri</th>
                                    <td>{{ $santri->nama_santri }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <th>Madrasah</th>
                                    <td>{{ $santri->madrasah->nama_madrasah ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td>{{ $santri->kamar->nama_kamar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>{{ \Carbon\Carbon::parse($santri->tanggal_daftar)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Tagihan -->
            <div class="col-lg-7 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Data Tagihan & Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        @forelse ($penagihan as $p)
                            <div class="mb-4 border rounded p-3">
                                <h6 class="fw-bold text-primary">
                                    {{ \Carbon\Carbon::createFromDate($p->tahun, $p->bulan, 1)->translatedFormat('F Y') }}
                                </h6>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm mb-2">
                                        <tr>
                                            <th>Biaya Makan</th>
                                            <td>Rp {{ number_format($p->biaya_makan, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Listrik</th>
                                            <td>Rp {{ number_format($p->biaya_listrik, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Sosial</th>
                                            <td>Rp {{ number_format($p->biaya_sosial, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Ianah</th>
                                            <td>Rp {{ number_format($p->biaya_ianah, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>
                                                <strong>Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($p->status_tagihan == 'belum_bayar')
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @elseif ($p->status_tagihan == 'pending_verifikasi')
                                                    <span class="badge bg-warning text-dark">Pending Verifikasi</span>
                                                @elseif ($p->status_tagihan == 'lunas')
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif ($p->status_tagihan == 'terlambat')
                                                    <span class="badge bg-secondary">Terlambat</span>
                                                @endif
                                            </td>
                                            @if ($p->status_tagihan !== 'lunas')
                                            
                                            <td class="text-end">
                                                <a href="{{ route('santri.pembayaran.create', $p->id_tagihan) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-money-bill-wave me-1"></i> Bayar
                                                </a>
                                            </td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>

                                <!-- Detail Pembayaran -->
                                <h6 class="mt-3">Pembayaran:</h6>
                                @if ($p->pembayaran->isEmpty())
                                    <p class="text-muted">Belum ada pembayaran.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Jumlah Bayar</th>
                                                    <th>Metode</th>
                                                    <th>Bank Pengirim</th>
                                                    <th>Nama Pengirim</th>
                                                    <th>Bukti Pembayaran</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($p->pembayaran as $bayar)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                                                        <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                                                        <td>{{ $bayar->metode_pembayaran }}</td>
                                                        <td>{{ $bayar->bank_pengirim ?? '-' }}</td>
                                                        <td>{{ $bayar->nama_pengirim ?? '-' }}</td>
                                                        <td>
                                                            @if ($bayar->bukti_pembayaran)
                                                                <button class="btn btn-sm btn-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#buktiModal{{ $bayar->id }}">
                                                                    Lihat
                                                                </button>

                                                                <!-- Modal Bukti -->
                                                                <div class="modal fade" id="buktiModal{{ $bayar->id }}" tabindex="-1"
                                                                    aria-labelledby="buktiModalLabel{{ $bayar->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="buktiModalLabel{{ $bayar->id }}">
                                                                                    Bukti Pembayaran
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ asset('storage/' . $bayar->bukti_pembayaran) }}"
                                                                                    alt="Bukti Pembayaran"
                                                                                    class="img-fluid rounded shadow">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Tidak ada</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($bayar->status_verifikasi == 'pending')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @elseif ($bayar->status_verifikasi == 'diverifikasi')
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($bayar->status_verifikasi == 'ditolak')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @else
                                                                <span class="badge bg-secondary">-</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $bayar->keterangan ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center">Tidak ada data tagihan.</p>
                        @endforelse
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
                popup: `animate__animated animate__fadeInUp animate__faster`
            },
            hideClass: {
                popup: `animate__animated animate__fadeOutDown animate__faster`
            }
        });
    });
</script>
@endif
