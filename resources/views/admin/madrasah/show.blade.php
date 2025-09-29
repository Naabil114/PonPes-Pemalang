@extends('layouts.index')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header d-flex align-items-center justify-content-between">
            <h3 class="fw-bold mb-3">Detail Madrasah: {{ $madrasah->nama_madrasah }}</h3>
            <a href="{{ route('madrasah.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-12">

                {{-- Detail Madrasah --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Informasi Madrasah</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Madrasah:</strong> {{ $madrasah->nama_madrasah }}</p>
                        <p><strong>Keterangan:</strong> {{ $madrasah->keterangan ?? '-' }}</p>
                        <p><strong>Status:</strong>
                            @if ($madrasah->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Daftar Santri --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Santri</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table id="santri-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. Telp</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($madrasah->santri as $santri)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $santri->nis }}</td>
                                            <td>{{ $santri->nama_santri }}</td>
                                            <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                            <td>{{ $santri->no_telp }}</td>
                                            <td>
                                                @if ($santri->status_santri == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada santri di madrasah ini</td>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $("#santri-table").DataTable({
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
@endpush
