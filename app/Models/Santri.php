<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use SoftDeletes;

    protected $table = 'santri';
    protected $primaryKey = 'id_santri';

    protected $fillable = [
        'user_id', 'nis', 'nama_santri', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'nama_orang_tua', 'no_telp', 'alamat',
        'id_madrasah', 'id_kamar', 'status_santri', 'tanggal_daftar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function madrasah()
    {
        return $this->belongsTo(Madrasah::class, 'id_madrasah');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    public function berkas()
    {
        return $this->hasOne(BerkasPendaftaran::class, 'id_santri');
    }

    public function pilihanMakan()
    {
        return $this->hasMany(PilihanMakanSantri::class, 'id_santri');
    }

    public function tagihanSpp()
    {
        return $this->hasMany(TagihanSpp::class, 'id_santri');
    }
}
