<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KamarController extends Controller
{

 public function cetakPdf($id, Request $request)
{
    $bulan = $request->query('bulan'); // contoh: 2025-09

    $kamar = Kamar::with([
        'santri.pilihanMakanTerbaru',
        'santri.tagihanSpp' => function ($q) use ($bulan) {
            if ($bulan) {
                $q->whereMonth('created_at', date('m', strtotime($bulan)))
                  ->whereYear('created_at', date('Y', strtotime($bulan)));
            }
        }
    ])->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.kamar.cetak_pdf', [
        'kamar' => $kamar,
        'bulan' => $bulan,
    ])->setPaper('A4', 'portrait');

    $namaFile = 'laporan_kamar_' . $kamar->nama_kamar;
    if ($bulan) {
        $namaFile .= '_' . str_replace('-', '_', $bulan);
    }

    return $pdf->download($namaFile . '.pdf');
}

    public function index()
    {
        $data = Kamar::all();
        return view('admin.kamar.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'nama_kamar' => 'required',
            'keterangan' => 'required',

        ]);

        $kamar = Kamar::create([
            'nama_kamar' => $request->nama_kamar,
            'keterangan' => $request->keterangan,
            'status' => 'aktif',
        ]);


        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);


        return view('admin.kamar.edit', compact('kamar'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_kamar' => 'required',
            'keterangan' => 'required',
            'status' => 'required',

        ]);


        $kamar = Kamar::findOrFail($id);



        $kamar->update([
            'nama_kamar' => $request->nama_kamar,
            'keterangan' => $request->keterangan,
            'status' => $request->status,

        ]);

        return redirect()->route('kamar.index')->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function show($id)
    {
        $kamar = Kamar::with(['santri.pilihanMakanTerbaru', 'santri.tagihanSpp'])->findOrFail($id);
        return view('admin.kamar.show', compact('kamar'));


    }

}
