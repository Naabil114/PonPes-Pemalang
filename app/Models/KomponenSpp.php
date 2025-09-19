<?php

namespace App\Models;

use App\Models\Madrasah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KomponenSpp extends Model
{
    use SoftDeletes;

    protected $table = 'komponen_spp';
    protected $primaryKey = 'id_komponen';

    protected $fillable = [
        'id_madrasah', 'nama_komponen', 'harga', 'kategori', 'keterangan', 'status'
    ];

    public function madrasah()
    {
        return $this->belongsTo(Madrasah::class, 'id_madrasah');
    }
}
