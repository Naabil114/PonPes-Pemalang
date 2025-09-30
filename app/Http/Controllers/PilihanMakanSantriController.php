<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use App\Models\PilihanMakanSantri;

class PilihanMakanSantriController extends Controller
{
    public function index()
    {
        $data = PilihanMakanSantri::whereHas('santri')->with('santri')->get();

        return view('admin.pilihan-makan.index', compact('data'));
    }

    public function create()
    {
        $santri = Santri::all();
        return view('admin.pilihan-makan.create', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'id_santri' => 'required',
            'jenis_makan' => 'required',
            
        ]);

        $pilihanMakanSantri = PilihanMakanSantri::create([
            'id_santri' => $request->id_santri,
            'bulan' => now()->month,
            'tahun' => now()->year,
            'jenis_makan' => $request->jenis_makan,
            'tanggal_pilih' => now(),
        ]);

        
        return redirect()->route('pilihan-makan-santri.index')->with('success', 'pilihan makan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = PilihanMakanSantri::with('santri')->findOrFail($id);
        // $santri = Santri::all();

        // dd($santri);
        return view('admin.pilihan-makan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'jenis_makan'   => 'required',
         
        ]);

        $data = PilihanMakanSantri::findOrFail($id);
        $data->update([
            'id_santri' => $request->id_santri,
            'jenis_makan' => $request->jenis_makan,
            'bulan' => now()->month,
            'tahun' => now()->year,
            'tanggal_pilih' => now(), 
            
        ]);

        return redirect()->route('pilihan-makan-santri.index')->with('success', 'Data pilihan makan berhasil diupdate!');
    }
}
