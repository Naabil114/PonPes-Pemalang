<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanSantri extends Model
{
    use SoftDeletes;

    protected $table = 'kegiatan_santri';
    protected $primaryKey = 'id_kegiatan_santri';

    protected $fillable = [
        'nama_kegiatan', 'jenis_kegiatan', 'keterangan_kegiatan'
    ];
}
