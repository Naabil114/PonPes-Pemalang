<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TagihanSpp;
use App\Models\KomponenSpp;
use Illuminate\Http\Request;
use App\Models\PilihanMakanSantri;
use Illuminate\Support\Facades\DB;

class PenagihanSantriController extends Controller
{
    public function index()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $data = Santri::with(['madrasah', 'kamar'])
            ->where('status_santri', 'aktif') 
            ->whereDoesntHave('tagihanSpp', function ($query) use ($bulan, $tahun) {
                $query->where('bulan', $bulan)
                    ->where('tahun', $tahun);
            })
            ->get();

        return view('admin.penagihan.index', compact('data'));
    }



    public function generateTagihan(Request $request, $id)
    {

        $santri = Santri::find($id);


        try {
            DB::beginTransaction();
            $idSantri = $santri->id_santri;
            $bulan = now()->month;
            $tahun = now()->year;
            $santriMadrasah = Santri::with(['madrasah'])->find($idSantri);
            $komponenSpp = KomponenSpp::where('id_madrasah', $santri->id_madrasah)
                ->where('status', 'aktif')
                ->get();
            //  dd($komponenSpp);
            $pilihanMakan = PilihanMakanSantri::where('id_santri', $idSantri)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            //  dd($pilihanMakan);

            // Inisialisasi biaya
            $biayaMakan = 0;
            $biayaListrik = 0;
            $biayaSosial = 0;
            $biayaIanah = 0;

            // Hitung biaya berdasarkan komponen SPP
            foreach ($komponenSpp as $komponen) {
                switch ($komponen->kategori) {
                    case 'makan':
                        // Biaya makan berdasarkan pilihan santri
                        if ($pilihanMakan) {
                            if (
                                $pilihanMakan->jenis_makan === 'sehari_1x' &&
                                $komponen->nama_komponen === 'Makan Sehari 1x'
                            ) {
                                $biayaMakan = $komponen->harga;
                            } elseif (
                                $pilihanMakan->jenis_makan === 'sehari_2x' &&
                                $komponen->nama_komponen === 'Makan Sehari 2x'
                            ) {
                                $biayaMakan = $komponen->harga;
                            }
                            // Jika 'tidak_ambil', biaya makan tetap 0
                        }
                        break;

                    case 'listrik':
                        $biayaListrik = $komponen->harga;
                        break;

                    case 'sosial':
                        $biayaSosial = $komponen->harga;
                        break;

                    case 'ianah':
                        $biayaIanah = $komponen->harga;
                        break;
                }
            }

            $totalTagihan = $biayaMakan + $biayaListrik + $biayaSosial + $biayaIanah;

            $tagihan = TagihanSpp::updateOrCreate(
                [
                    'id_santri' => $idSantri,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'biaya_makan' => $biayaMakan,
                    'biaya_listrik' => $biayaListrik,
                    'biaya_sosial' => $biayaSosial,
                    'biaya_ianah' => $biayaIanah,
                    'total_tagihan' => $totalTagihan,
                    'status_tagihan' => 'belum_bayar',
                ]
            );

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with('success', 'Tagihan SPP berhasil dibuat!');
    }

    public function generateAllTagihan()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        try {
            DB::beginTransaction();

            // Ambil semua santri yang belum ditagih bulan ini
            $santriList = Santri::whereDoesntHave('tagihanSpp', function ($query) use ($bulan, $tahun) {
                $query->where('bulan', $bulan)->where('tahun', $tahun);
            })->get();

            if ($santriList->isEmpty()) {
                return redirect()->back()->with('warning', 'Semua santri sudah memiliki tagihan bulan ini.');
            }

            foreach ($santriList as $santri) {
                $idSantri = $santri->id_santri;

                // Ambil data komponen SPP sesuai madrasah
                $komponenSpp = KomponenSpp::where('id_madrasah', $santri->id_madrasah)
                    ->where('status', 'aktif')
                    ->get();

                // Ambil pilihan makan bulan ini
                $pilihanMakan = PilihanMakanSantri::where('id_santri', $idSantri)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                // Inisialisasi biaya
                $biayaMakan = 0;
                $biayaListrik = 0;
                $biayaSosial = 0;
                $biayaIanah = 0;

                // Hitung biaya berdasarkan komponen SPP
                foreach ($komponenSpp as $komponen) {
                    switch ($komponen->kategori) {
                        case 'makan':
                            if ($pilihanMakan) {
                                if ($pilihanMakan->jenis_makan === 'sehari_1x' && $komponen->nama_komponen === 'Makan Sehari 1x') {
                                    $biayaMakan = $komponen->harga;
                                } elseif ($pilihanMakan->jenis_makan === 'sehari_2x' && $komponen->nama_komponen === 'Makan Sehari 2x') {
                                    $biayaMakan = $komponen->harga;
                                }
                                // Jika tidak_ambil => biaya makan tetap 0
                            }
                            break;

                        case 'listrik':
                            $biayaListrik = $komponen->harga;
                            break;

                        case 'sosial':
                            $biayaSosial = $komponen->harga;
                            break;

                        case 'ianah':
                            $biayaIanah = $komponen->harga;
                            break;
                    }
                }

                $totalTagihan = $biayaMakan + $biayaListrik + $biayaSosial + $biayaIanah;

                // Simpan tagihan
                TagihanSpp::create([
                    'id_santri' => $idSantri,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'biaya_makan' => $biayaMakan,
                    'biaya_listrik' => $biayaListrik,
                    'biaya_sosial' => $biayaSosial,
                    'biaya_ianah' => $biayaIanah,
                    'total_tagihan' => $totalTagihan,
                    'status_tagihan' => 'belum_bayar',
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Tagihan untuk semua santri berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
