@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Detail Santri & Tagihan</h3>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            </div>
            <br>

            {{-- Detail Santri --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Santri</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>NIS</th>
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

            {{-- Detail Tagihan --}}
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Data Tagihan & Pembayaran</h5>
                </div>
                <div class="card-body">
                    @foreach ($penagihan as $p)
                        <div class="mb-4 border rounded p-3">
                            <h6 class="fw-bold">
                                {{ \Carbon\Carbon::createFromDate($p->tahun, $p->bulan, 1)->translatedFormat('F Y') }}
                            </h6>

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
                                    <td><strong>Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</strong></td>
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
                                </tr>
                                @if ($p->status_tagihan !== 'lunas')
                                    <tr>
                                        <th>

                                        </th>
                                        <td class="text-end">
                                            <form id="formBayarCash-{{ $p->id_tagihan }}"
                                                action="{{ route('admin.pembayaran.cash', $p->id_tagihan) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="button" class="btn btn-success btn-sm btn-bayar-cash"
                                                    data-id="{{ $p->id_tagihan }}"
                                                    data-nama="{{ $p->santri->nama_santri }}">
                                                    <i class="fas fa-money-bill-wave me-1"></i> Bayar Cash
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @endif
                            </table>

                            {{-- Detail Pembayaran --}}
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($p->pembayaran as $bayar)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                                                    <td>{{ $bayar->metode_pembayaran }}</td>
                                                    <td>{{ $bayar->bank_pengirim ?? '-' }}</td>
                                                    <td>{{ $bayar->nama_pengirim ?? '-' }}</td>
                                                    <td>
                                                        @if ($bayar->bukti_pembayaran)
                                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                                data-bs-target="#buktiModal{{ $bayar->id_pembayaran }}">
                                                                Lihat Bukti
                                                            </button>

                                                            <!-- Modal Bukti -->
                                                            <div class="modal fade"
                                                                id="buktiModal{{ $bayar->id_pembayaran }}" tabindex="-1"
                                                                aria-labelledby="buktiModalLabel{{ $bayar->id_pembayaran }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            <img src="{{ asset('storage/' . $bayar->bukti_pembayaran) }}"
                                                                                alt="Bukti Pembayaran"
                                                                                class="img-fluid rounded">
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

                                                    <td>
                                                        @if ($bayar->status_verifikasi == 'pending')
                                                            <div class="d-flex gap-1">
                                                                <!-- Tombol Lunas -->
                                                                <form id="form-lunas-{{ $bayar->id_pembayaran }}"
                                                                    action="{{ route('pembayaran.lunas', $bayar->id_pembayaran) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="button"
                                                                        class="btn btn-success btn-sm btn-lunas"
                                                                        data-id="{{ $bayar->id_pembayaran }}">
                                                                        Lunas
                                                                    </button>
                                                                </form>

                                                                <!-- Tombol Tolak -->
                                                                <form id="form-tolak-{{ $bayar->id_pembayaran }}"
                                                                    action="{{ route('pembayaran.tolak', $bayar->id_pembayaran) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#tolakModal{{ $bayar->id_pembayaran }}">
                                                                        Tolak </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Modal Tolak -->
                                                <div class="modal fade" id="tolakModal{{ $bayar->id_pembayaran }}"
                                                    tabindex="-1"
                                                    aria-labelledby="tolakModalLabel{{ $bayar->id_pembayaran }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form
                                                            action="{{ route('pembayaran.tolak', $bayar->id_pembayaran) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Tolak Pembayaran</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="keterangan"
                                                                            class="form-label">Keterangan
                                                                            Penolakan</label>
                                                                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Tolak</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-lunas").forEach(btn => {
            btn.addEventListener("click", function() {
                let id = this.dataset.id;
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Status pembayaran akan diubah menjadi LUNAS.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, setujui!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("form-lunas-" + id).submit();
                    }
                });
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-bayar-cash').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                let id = this.getAttribute('data-id');
                let nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: "Apakah Anda yakin ingin melakukan pembayaran cash untuk santri: " +
                        nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, bayar!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formBayarCash-' + id).submit();
                    }
                });
            });
        });
    });
</script>
