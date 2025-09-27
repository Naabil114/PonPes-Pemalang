<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;

class TagihanSantriController extends Controller
{
    public function index()
    {
        $tagihan = TagihanSpp::with('santri')->get();
        // dd($tagihan);
        return view('admin.data-tagihan.index', compact('tagihan'));
    }

    public function show($id_santri)
    {
        $santri = Santri::with(['madrasah', 'kamar'])->findOrFail($id_santri);

        $penagihan = TagihanSpp::with('pembayaran')
            ->where('id_santri', $id_santri)
            ->get();

        return view('admin.data-tagihan.show', compact('santri', 'penagihan'));
    }

    public function tagihanSantri()
    {
        $tagihan = TagihanSpp::with('santri')->get();
        return view('santri.tagihan-santri.index', compact('tagihan'));
    }

    public function showTagihan($id_santri)
    {
        $santri = Santri::with(['madrasah', 'kamar'])->findOrFail($id_santri);

        $penagihan = TagihanSpp::with('pembayaran')
            ->where('id_santri', $id_santri)
            ->get();
        // dd($penagihan);

        return view('santri.tagihan-santri.show', compact('santri', 'penagihan'));
    }






}
