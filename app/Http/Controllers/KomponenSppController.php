<?php

namespace App\Http\Controllers;

use App\Models\KomponenSpp;
use App\Models\Madrasah;
use Illuminate\Http\Request;

class KomponenSppController extends Controller
{
    // Menampilkan data komponen spp
    public function index()
    {
        $data = KomponenSpp::with('madrasah')->get();
        return view('admin.komponen-spp.index', compact('data'));
    }

    // Form tambah data
    public function create()
    {
        $madrasah = Madrasah::all();
        return view('admin.komponen-spp.create', compact('madrasah'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'id_madrasah'   => 'required|exists:madrasah,id_madrasah',
            'nama_komponen' => 'required|string|max:255',
            'harga'         => 'required|numeric',
            'kategori'      => 'required|string',
            'keterangan'    => 'nullable|string',
            'status'        => 'required|in:aktif,tidak_aktif'
        ]);

        KomponenSpp::create($request->all());

        return redirect()->route('komponen_spp.index')->with('success', 'Data komponen SPP berhasil ditambahkan!');
    }

    // Form edit data
    public function edit($id)
    {
        $data = KomponenSpp::findOrFail($id);
        $madrasah = Madrasah::all();
        return view('admin.komponen-spp.edit', compact('data', 'madrasah'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_madrasah'   => 'required|exists:madrasah,id_madrasah',
            'nama_komponen' => 'required|string|max:255',
            'harga'         => 'required|numeric',
            'kategori'      => 'required|string',
            'keterangan'    => 'nullable|string',
            'status'        => 'required|in:aktif,tidak_aktif'
        ]);

        $data = KomponenSpp::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('komponen_spp.index')->with('success', 'Data komponen SPP berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $data = KomponenSpp::findOrFail($id);
        $data->delete();

        return redirect()->route('komponen_spp.index')->with('success', 'Data komponen SPP berhasil dihapus!');
    }
}
