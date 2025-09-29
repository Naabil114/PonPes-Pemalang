@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Konfirmasi Pendaftaran Santri</h3>
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
                        <a href="#">Pendaftaran</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Konfirmasi</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Pendaftar</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama Santri</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Orang Tua</th>
                                            <th>No. Telepon</th>
                                            <th>Status</th>
                                            <th style="width: 18%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pendaftar as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nis }}</td>
                                                <td>{{ $item->nama_santri }}</td>
                                                <td>
                                                    {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                </td>
                                                <td>{{ $item->nama_orang_tua }}</td>
                                                <td>{{ $item->no_telp }}</td>
                                                <td>
                                                    @if ($item->status_santri == 'pendaftar')
                                                        <span class="badge bg-warning text-dark">Pendaftar</span>
                                                    @elseif ($item->status_santri == 'diterima')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($item->status_santri == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-button-action d-flex gap-2">
                                                        {{-- Tombol Detail --}}
                                                        <a href="{{ route('pendaftaran.show', $item->id_santri) }}">
                                                            <button class="btn btn-info btn-sm">Detail</button>
                                                        </a>

                                                        {{-- Tombol Terima --}}
                                                        <button type="button" class="btn btn-success btn-sm btn-terima"
                                                            data-id="{{ $item->id_santri }}">
                                                            Terima  
                                                        </button>

                                                        {{-- Tombol Tolak --}}
                                                        <form action="{{ route('pendaftaran.tolak', $item->id_santri) }}"
                                                            method="POST" class="d-inline form-tolak">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn btn-danger btn-sm btn-tolak">
                                                                Tolak
                                                            </button>
                                                        </form>

                                                    </div>
                                                    <!-- Modal Terima -->
                                                    <div class="modal fade" id="modalTerima" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form id="formTerima" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Konfirmasi Terima Santri
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_santri"
                                                                            id="id_santri">

                                                                        <div class="mb-3">
                                                                            <label for="id_madrasah"
                                                                                class="form-label">Madrasah</label>
                                                                            <select name="id_madrasah" id="id_madrasah"
                                                                                class="form-select" required>
                                                                                <option value="">-- Pilih Madrasah --
                                                                                </option>
                                                                                @foreach ($madrasah as $m)
                                                                                    <option value="{{ $m->id_madrasah }}">
                                                                                        {{ $m->nama_madrasah }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="id_kamar"
                                                                                class="form-label">Kamar</label>
                                                                            <select name="id_kamar" id="id_kamar"
                                                                                class="form-select" required>
                                                                                <option value="">-- Pilih Kamar --
                                                                                </option>
                                                                                @foreach ($kamar as $k)
                                                                                    <option value="{{ $k->id_kamar }}">
                                                                                        {{ $k->nama_kamar }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada pendaftar</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> <!-- end table responsive -->
                        </div> <!-- end card body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SweetAlert untuk flash message --}}
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

{{-- DataTables --}}
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#add-row").DataTable({
            pageLength: 10,
            responsive: true,
            autoWidth: false,
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.querySelectorAll('.btn-terima').forEach(function(button) {
            button.addEventListener('click', function() {
                let idSantri = this.getAttribute('data-id');
                let form = document.getElementById('formTerima');

                // Set action form sesuai santri yang dipilih
                form.setAttribute('action', '/pendaftaran/terima/' + idSantri);
                document.getElementById('id_santri').value = idSantri;

                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('modalTerima'));
                modal.show();
            });
        });

        // Tombol Tolak
        document.querySelectorAll('.btn-tolak').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Yakin ingin menolak santri ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

    });
</script>
