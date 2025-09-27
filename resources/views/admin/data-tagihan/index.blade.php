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
                        <a href="#">Data tagihan</a>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tagihan</th>
                                            <th>Nama Santri</th>
                                            <th>Nomor Telp</th>
                                            <th>Status Tagihan</th>
                                            <th style="width: 12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tagihan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::createFromDate($item->tahun, $item->bulan, 1)->translatedFormat('F Y') }}
                                                </td>

                                                <td>{{ $item->santri->nama_santri }}</td>
                                                <td>
                                                    @if ($item->santri->no_telp)
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->santri->no_telp) }}"
                                                            target="_blank" class="text-success" title="Chat via WhatsApp">
                                                            <i class="fab fa-whatsapp fa-lg"></i>
                                                            {{ $item->santri->no_telp }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($item->status_tagihan == 'belum_bayar')
                                                        <span class="badge bg-danger">Belum Bayar</span>
                                                    @elseif ($item->status_tagihan == 'pending_verifikasi')
                                                        <span class="badge bg-warning text-dark">Pending Verifikasi</span>
                                                    @elseif ($item->status_tagihan == 'lunas')
                                                        <span class="badge bg-success">Lunas</span>
                                                    @elseif ($item->status_tagihan == 'terlambat')
                                                        <span class="badge bg-secondary">Terlambat</span>
                                                    @endif
                                                </td>


                                                <td>
                                                    <div class="form-button-action d-flex gap-2">
                                                        <a href="{{ route('penagihan-santri.show', $item->id_santri) }}"
                                                            class="btn btn-info btn-sm">
                                                            Detail
                                                        </a>
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Data pilih makan tidak tersedia</td>
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
        const formTagihSemua = document.getElementById('form-tagih-semua');
        const btnTagihSemua = document.getElementById('btn-tagih-semua');

        btnTagihSemua.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua santri yang belum ditagih bulan ini akan dibuatkan tagihan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tagih Semua',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formTagihSemua.submit();
                }
            });
        });
    });
</script>
