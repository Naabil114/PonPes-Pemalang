<?php

namespace App\Models;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BerkasPendaftaran extends Model
{
    use SoftDeletes;

    protected $table = 'berkas_pendaftaran';
    protected $primaryKey = 'id_berkas';

    protected $fillable = [
        'id_santri', 'file_kk', 'file_akta_kelahiran', 'file_ijazah_sd',
        'file_skhu_sd', 'file_pas_foto', 'status_verifikasi', 'keterangan',
        'diverifikasi_oleh', 'tanggal_verifikasi'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
