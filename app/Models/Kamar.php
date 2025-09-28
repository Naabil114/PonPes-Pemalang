<?php

namespace App\Models;

use App\Models\Santri;
use App\Models\PilihanMakanSantri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use SoftDeletes;

    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';

    protected $fillable = ['nama_kamar', 'keterangan', 'status'];

    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_kamar');
    }



    // Santri.php
    // jika ingin menyimpan semua riwayat
public function pilihanMakan()
{
    return $this->hasMany(PilihanMakanSantri::class, 'id_santri', 'id_santri');
}

// relasi untuk ambil 1 (terbaru)
public function pilihanMakanTerbaru()
{
    return $this->hasOne(PilihanMakanSantri::class, 'id_santri', 'id_santri')
                ->latestOfMany('tanggal_pilih'); // ambil berdasarkan tanggal_pilih
}



    public function tagihanSpp()
    {
        return $this->hasMany(TagihanSpp::class, 'id_santri', 'id_santri');
    }

}
