<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kamar;
use App\Models\Santri;
use App\Models\Madrasah;
use Illuminate\Http\Request;
use App\Models\BerkasPendaftaran;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    public function pendaftaranForm()
    {
        return view('santri.pendaftaran.form-pendaftaran');
    }

    public function submitPendaftaran(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama_santri' => 'required|string|max:180',
            'tempat_lahir' => 'required|string|max:180',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_orang_tua' => 'required|string|max:180',
            'no_telp' => 'required|string|max:13',
            'alamat' => 'required|string|max:500',
        ], [
            'required' => 'Field :attribute harus diisi.',
            'max' => 'Field :attribute maksimal :max karakter.',
            'in' => 'Field :attribute harus diisi dengan pilihan yang benar.',
            'date' => 'Field :attribute harus berupa tanggal yang valid.',
            'string' => 'Field :attribute harus berupa string.',
            'numeric' => 'Field :attribute harus berupa angka.',

        ]);

        $user = User::create([
            'username' => $request->no_telp,
            'password' => Hash::make($request->no_telp),
            'role' => 'santri',
        ]);
        $jumlahSantri = Santri::count();
        // dd( $jumlahSantri);
        $nisBaru = str_pad($jumlahSantri + 1, 5, '0', STR_PAD_LEFT);
        // dd( $nisBaru);

        $santri = Santri::create([
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

        ]);

        // Simpan berkas pendaftaran
        $berkas = new BerkasPendaftaran();
        $berkas->id_santri = $santri->id_santri;

        // Upload file
        if ($request->hasFile('file_kk')) {
            $berkas->file_kk = $request->file('file_kk')->store('berkas/kk', 'public');
        }
        if ($request->hasFile('file_akta_kelahiran')) {
            $berkas->file_akta_kelahiran = $request->file('file_akta_kelahiran')->store('berkas/akta', 'public');
        }
        if ($request->hasFile('file_ijazah_sd')) {
            $berkas->file_ijazah_sd = $request->file('file_ijazah_sd')->store('berkas/ijazah', 'public');
        }
        if ($request->hasFile('file_skhu_sd')) {
            $berkas->file_skhu_sd = $request->file('file_skhu_sd')->store('berkas/skhu', 'public');
        }
        if ($request->hasFile('file_pas_foto')) {
            $berkas->file_pas_foto = $request->file('file_pas_foto')->store('berkas/foto', 'public');
        }

        $berkas->status_verifikasi = 'pending';
        $berkas->save();



        return redirect()->route('register.success');

    }


    public function index()
    {
        $madrasah = Madrasah::all();
        $kamar = Kamar::all();
        $pendaftar = Santri::orderBy('created_at', 'desc')->where('status_santri', 'pendaftar')->get();
        return view('admin.pendaftaran.index', compact('pendaftar', 'madrasah', 'kamar'));
    }

    // Detail pendaftar
    public function show($id)
    {
        $santri = Santri::with('berkas')->findOrFail($id);
        return view('admin.pendaftaran.show', compact('santri'));
    }


    // Terima pendaftar
    public function terima(Request $request, $id)
    {
        $request->validate([
            'id_madrasah' => 'required|exists:madrasah,id_madrasah',
            'id_kamar' => 'required|exists:kamar,id_kamar',
        ]);

        $santri = Santri::findOrFail($id);
        $santri->update([
            'status_santri' => 'aktif',
            'id_madrasah' => $request->id_madrasah,
            'id_kamar' => $request->id_kamar,
        ]);

        return redirect()->route('pendaftaran.index')->with('success', 'Santri berhasil diterima.');
    }


    // Tolak pendaftar
    public function tolak($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->status_santri = 'tolak';
        $santri->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Santri ditolak.');
    }
}
