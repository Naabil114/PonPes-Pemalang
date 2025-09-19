<?php

namespace App\Models;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PilihanMakanSantri extends Model
{
    use SoftDeletes;

    protected $table = 'pilihan_makan_santri';
    protected $primaryKey = 'id_pilihan_makan';

    protected $fillable = ['id_santri', 'bulan', 'tahun', 'jenis_makan', 'tanggal_pilih'];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
