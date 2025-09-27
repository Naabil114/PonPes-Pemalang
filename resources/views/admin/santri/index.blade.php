@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Forms</h3>
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
                        <a href="#">Data Santri</a>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Santri</h4>
                                <div class="ms-auto">
                                    <a href="{{ route('santri.create') }}">
                                        <button class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i>
                                            Tambah Santri
                                        </button>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Kelas</th> <!-- Madrasah -->
                                            <th>Kamar</th> <!-- Kamar -->
                                            <th>Status Santri</th>
                                            <th style="width: 12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nis }}</td>
                                                <td>{{ $item->nama_santri }}</td>
                                                <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                                <td>{{ $item->madrasah->nama_madrasah ?? '-' }}</td>
                                                <td>{{ $item->kamar->nama_kamar ?? '-' }}</td> <!-- ambil nama kamar -->
                                                <td>{{ $item->tanggal_daftar }}</td>
                                                <td>
                                                    @if ($item->status_santri == 'pendaftar')
                                                        <span class="badge bg-secondary">Pendaftar</span>
                                                    @elseif ($item->status_santri == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @elseif ($item->status_santri == 'alumni')
                                                        <span class="badge bg-info">Alumni</span>
                                                    @elseif ($item->status_santri == 'keluar')
                                                        <span class="badge bg-danger">Keluar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-button-action d-flex gap-2">
                                                        <!-- Tombol Detail -->
                                                        <a href="{{ route('santri.show', $item->id_santri) }}">
                                                            <button class="btn btn-success btn-sm">Detail</button>
                                                        </a>

                                                        <!-- Tombol Edit -->
                                                        <a href="{{ route('santri.edit', $item->id_santri) }}">
                                                            <button class="btn btn-warning btn-sm">Edit</button>
                                                        </a>

                                                        <!-- Tombol Hapus -->
                                                        <form action="{{ route('santri.destroy', $item->id_santri) }}"
                                                            method="POST" class="d-inline form-delete">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Hapus
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Data santri tidak tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>

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


<!-- DataTables CSS via CDN -->

<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>


<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel #add-row
        $("#add-row").DataTable({
            pageLength: 10, // jumlah data per halaman
            responsive: true, // agar tabel responsif
            autoWidth: false, // supaya kolom tidak auto lebar
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua form dengan class form-delete
        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop form dari submit langsung

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data santri dan akun user akan dihapus softdelete!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Lanjutkan submit jika user klik 'Ya, hapus!'
                    }
                });
            });
        });
    });
</script>
