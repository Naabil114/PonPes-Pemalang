<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kamar;
use App\Models\Santri;
use App\Models\Madrasah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    public function index()
    {
        // Ambil santri beserta madrasah & kamar
        $data = Santri::with(['madrasah', 'kamar'])->get();

        return view('admin.santri.index', compact('data'));
    }


    public function create()
    {
        $madrasah = Madrasah::all();
        $kamar = Kamar::all();
        return view('admin.santri.create', compact('madrasah', 'kamar'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'nama_santri' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_orang_tua' => 'required',
            'no_telp' => 'required|unique:santri',
            'alamat' => 'required',
            'id_madrasah' => 'required|exists:madrasah,id_madrasah',
            'id_kamar' => 'required|exists:kamar,id_kamar',
        ]);

        // Insert ke tabel users
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'santri',
        ]);

        // Hitung jumlah santri aktif (tidak terhapus)
        $jumlahSantri = Santri::whereNull('deleted_at')->count();

        // Generate NIS baru (misal 00001, 00002, dst)
        $nisBaru = str_pad($jumlahSantri + 1, 5, '0', STR_PAD_LEFT);

        // Insert ke tabel santri
        Santri::create([
            'user_id' => $user->id,
            'nis' => $nisBaru,
            'nama_santri' => $request->nama_santri,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_orang_tua' => $request->nama_orang_tua,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_daftar' => now(),
            'status_santri' => 'pendaftar',
            'id_madrasah' => $request->id_madrasah,
            'id_kamar' => $request->id_kamar,
        ]);

        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan!');
    }




    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        $madrasah = Madrasah::all();
        $kamar = Kamar::all();

        return view('admin.santri.edit', compact('santri', 'madrasah', 'kamar'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'username' => 'required|unique:users,username,' . $request->user_id . ',id',
            'nama_santri' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_orang_tua' => 'required',
            'no_telp' => 'required|unique:santri,no_telp,' . $id . ',id_santri',
            'alamat' => 'required',
            'id_madrasah' => 'required|exists:madrasah,id_madrasah',
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'status_santri' => 'required|in:pendaftar,aktif,alumni,keluar',
        ]);


        $santri = Santri::findOrFail($id);

        // Update user (jika username diganti)
        $user = User::findOrFail($santri->user_id);
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update data santri
        $santri->update([
            'nama_santri' => $request->nama_santri,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_orang_tua' => $request->nama_orang_tua,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'id_madrasah' => $request->id_madrasah,
            'id_kamar' => $request->id_kamar,
            'status_santri' => $request->status_santri,
        ]);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari santri berdasarkan ID
        $santri = Santri::findOrFail($id);

        // Simpan ID user terkait sebelum dihapus
        $userId = $santri->user_id;

        // Hapus data santri
        $santri->delete();

        // Hapus juga data user yang berelasi
        if ($userId) {
            User::where('id', $userId)->delete();
        }

        return redirect()->route('santri.index')->with('success', 'Data santri dan akun user berhasil dihapus.');
    }
    public function show($id)
    {
        // Ambil data santri berdasarkan id dengan relasi madrasah dan kamar
        $santri = Santri::with(['madrasah', 'kamar', 'user'])->findOrFail($id);

        return view('admin.santri.detail', compact('santri'));
    }



}
