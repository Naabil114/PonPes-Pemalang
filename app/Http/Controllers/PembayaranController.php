<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rekening;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use App\Models\PembayaranSpp;

class PembayaranController extends Controller
{
    public function create($id)
    {
        $tagihan = TagihanSpp::with('santri')->findOrFail($id);
        $rekening = Rekening::all();
        // dd($tagihan);
        return view('santri.pembayaran.create', compact('tagihan', 'rekening'));
    }

    public function store(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1000',
            // 'tanggal_bayar' => 'required|date',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            // 'metode_pembayaran' => 'required|string',
            'bank_pengirim' => 'required|string',
            'nama_pengirim' => 'required|string',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran harus diisi.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus berupa jpg, jpeg, atau png.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran tidak boleh lebih dari 2MB.',
            'jumlah_bayar.min' => 'Jumlah bayar minimal adalah Rp 1000.',
            'bank_pengirim.required' => 'Bank pengirim harus diisi.',
            'nama_pengirim.required' => 'Nama pengirim harus diisi.',

        ]);
        // dd($request->all());

        $bukti = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $bukti = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }
        // dd($bukti);
        $tagihan = TagihanSpp::findOrFail($id);
        // dd($tagihan);
        // dd($bukti);

        PembayaranSpp::create([
            'id_tagihan' => $id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => now()->format('Y-m-d'),
            'bukti_pembayaran' => $bukti,
            'metode_pembayaran' => 'transfer_bank',
            'bank_pengirim' => $request->bank_pengirim,
            'nama_pengirim' => $request->nama_pengirim,
            'status_verifikasi' => 'pending',
            // 'diverifikasi_oleh' => auth()->user()->id,
            // 'tanggal_verifikasi' => now()->format('Y-m-d'),
        ]);
        // dd($tagihan);

        // Update status tagihan jadi pending_verifikasi
        $tagihan->update([
            'status_tagihan' => 'pending_verifikasi',
        ]);

        return redirect()
    ->route('santri.tagihan.show', $tagihan->id_santri)
    ->with('success', 'Pembayaran berhasil diajukan, menunggu verifikasi.');


    }

     public function setLunas($id)
    {
        $pembayaran = PembayaranSpp::findOrFail($id);
        $tagihan = TagihanSpp::findOrFail($pembayaran->id_tagihan);

        // Update pembayaran
        $pembayaran->update([
            'status_verifikasi' => 'diverifikasi',
            'tanggal_verifikasi' => Carbon::now(),
            'diverifikasi_oleh' => auth()->id(),
            'keterangan' => null
        ]);

        // Update status tagihan
        $tagihan->update([
            'status_tagihan' => 'lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi sebagai Lunas.');
    }

    // Tolak pembayaran dengan keterangan
    public function setTolak(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $pembayaran = PembayaranSpp::findOrFail($id);
        $tagihan = TagihanSpp::findOrFail($pembayaran->id_tagihan);

        // Update pembayaran
        $pembayaran->update([
            'status_verifikasi' => 'ditolak',
            'tanggal_verifikasi' => Carbon::now(),
            'diverifikasi_oleh' => auth()->id(),
            'keterangan' => $request->keterangan
        ]);

        // Jika ditolak, tagihan kembali ke status belum bayar
        $tagihan->update([
            'status_tagihan' => 'belum_bayar'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}

