<?php

namespace App\Http\Controllers;

use App\Models\Madrasah;
use Illuminate\Http\Request;

class MadrasahController extends Controller
{
    public function index()
    {
        $data = Madrasah::all();
        return view('admin.madrasah.index', compact('data'));
    }

    public function create()
    {
        return view('admin.madrasah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'nama_madrasah' => 'required',
            'deskripsi' => 'required',
            
        ]);

        $madrasah = Madrasah::create([
            'nama_madrasah' => $request->nama_madrasah,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        
        return redirect()->route('madrasah.index')->with('success', 'madrasah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $madrasah = Madrasah::findOrFail($id);
        

        return view('admin.madrasah.edit', compact('madrasah'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_madrasah' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
            
        ]);


        $madrasah = Madrasah::findOrFail($id);

        

        $madrasah->update([
            'nama_madrasah' => $request->nama_madrasah,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            
        ]);

        return redirect()->route('madrasah.index')->with('success', 'Data madrasah berhasil diperbarui!');
    }

    public function show($id)
    {
        $madrasah = Madrasah::with('santri')->findOrFail($id);
        return view('admin.madrasah.show', compact('madrasah'));
    }
}
