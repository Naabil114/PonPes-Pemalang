@extends('layouts.index')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Komponen SPP</h3>
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
                    <a href="#">Komponen SPP</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title">Daftar Komponen</h4>
                <div class="ms-auto">
                    <a href="{{ route('komponen_spp.create') }}" class="btn btn-primary btn-round">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
                    <table id="add-row" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Madrasah</th>
                                <th>Nama Komponen</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th style="width: 12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->madrasah->nama_madrasah ?? '-' }}</td>
                                <td>{{ $item->nama_komponen }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($item->kategori) }}</td>
                                <td>
                                    @if ($item->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('komponen_spp.edit', $item->id_komponen) }}"><button class="btn btn-warning btn-sm">Edit</button></a>
                                        <form action="{{ route('komponen_spp.destroy', $item->id_komponen) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Data tidak tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua form dengan class form-delete
        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
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

