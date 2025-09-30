@extends('layouts.index')

@section('content')

    <div class="container">
      
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Laporan Pembayaran Santri</h3>
            </div>
            @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

            <div class="card p-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Pilih Santri</label>
                        <select id="santri" class="form-control"></select>
                    </div>
                    <div class="col-md-3">
                        <label>Bulan</label>
                        <select id="bulan" class="form-control">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tahun</label>
                        <select id="tahun" class="form-control">
                            @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-primary" id="tampilkan">Tampilkan</button>

                    <form id="formCetakPdf" action="{{ route('laporan.pembayaran.cetakPdf') }}" method="GET"
                        class="d-inline" style="display:none;">
                        <input type="hidden" name="id_santri" id="cetak_id_santri">
                        <input type="hidden" name="bulan" id="cetak_bulan">
                        <input type="hidden" name="tahun" id="cetak_tahun">
                        <button type="submit" class="btn btn-danger ms-2">Cetak PDF</button>
                    </form>
                </div>




                {{-- <div id="hasilLaporan" class="mt-4"></div> --}}

            </div>

            <div id="hasilLaporan" class="mt-4"></div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#santri').select2({
        placeholder: "Cari santri...",
        ajax: {
            url: "{{ route('laporan.pembayaran.searchSantri') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };
            },
            processResults: function(data) {
                return { results: data.results };
            },
            cache: true
        },
        minimumInputLength: 1,
        width: '100%'
    });

    $('#tampilkan').on('click', function() {
        let id_santri = $('#santri').val();
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();

        if (!id_santri) {
            Swal.fire('Peringatan', 'Pilih santri dulu!', 'warning');
            return;
        }

        $.get("{{ route('laporan.pembayaran.data') }}", {
            id_santri: id_santri,
            bulan: bulan,
            tahun: tahun
        }, function(html) {
            $('#hasilLaporan').html(html);

            // isi hidden input form cetak PDF
            $('#cetak_id_santri').val(id_santri);
            $('#cetak_bulan').val(bulan);
            $('#cetak_tahun').val(tahun);

            // tampilkan tombol cetak PDF
            $('#formCetakPdf').show();
        }).fail(function(xhr) {
            console.error(xhr.responseText);
            Swal.fire('Error', 'Gagal memuat laporan.', 'error');
        });
    });
});
</script>
