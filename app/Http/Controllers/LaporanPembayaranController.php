<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\TagihanSpp;
use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        return view('admin.laporan.pembayaran.index');
    }

    // Live search santri
   public function searchSantri(Request $request)
{
    $search = $request->get('q');

    $santri = Santri::where('nama_santri', 'like', "%{$search}%")
        ->select('id_santri', 'nis', 'nama_santri')
        ->limit(10)
        ->get();

    $results = $santri->map(function ($s) {
        return [
            'id' => $s->id_santri,
            'text' => $s->nis . ' - ' . $s->nama_santri,
        ];
    });

    return response()->json(['results' => $results]);
}



    // Get laporan data per santri per bulan
    public function getData(Request $request)
{
    $id_santri = $request->get('id_santri');
    $bulan     = $request->get('bulan');
    $tahun     = $request->get('tahun');

    $tagihan = TagihanSpp::with('pembayaran')
        ->where('id_santri', $id_santri)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->first();

    return view('admin.laporan.pembayaran._data', compact('tagihan'))->render();
}


public function cetakPdf(Request $request)
{
    $id_santri = $request->get('id_santri');
    $bulan     = $request->get('bulan');
    $tahun     = $request->get('tahun');

    $tagihan = \App\Models\TagihanSpp::with('pembayaran', 'santri')
        ->where('id_santri', $id_santri)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->first();

    // kalau data tidak ada
    if (!$tagihan) {
        return redirect()
            ->back()
            ->with('error', 'Data tagihan tidak ditemukan.');
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'admin.laporan.pembayaran.pdf',
        compact('tagihan')
    )->setPaper('A4', 'portrait');

    return $pdf->download(
        'laporan-pembayaran-' .
        str_replace(' ', '_', strtolower($tagihan->santri->nama_santri)) .
        '-' . $bulan . '-' . $tahun . '.pdf'
    );
}




}
