@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"></h3>
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
                        <a href="#">Data kamar</a>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data kamar</h4>
                                <div class="ms-auto">
                                    <a href="{{ route('kamar.create') }}">
                                        <button class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i>
                                            Tambah kamar
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
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th style="width: 12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_kamar }}</td>
                                                <td>{{ $item->keterangan }}</td>

                                                <td>
                                                    @if ($item->status == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @elseif ($item->status == 'tidak_aktif')
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-button-action d-flex gap-2">


                                                        <!-- Tombol Edit -->
                                                        <a href="{{ route('kamar.edit', $item->id_kamar) }}">
                                                            <button class="btn btn-warning btn-sm">Edit</button>
                                                        </a>


                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Data kamar tidak tersedia</td>
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
