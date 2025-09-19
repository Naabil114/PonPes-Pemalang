<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
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
}
