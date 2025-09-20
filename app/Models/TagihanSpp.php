<?php

namespace App\Models;

use App\Models\Santri;
use App\Models\PembayaranSpp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagihanSpp extends Model
{
    use SoftDeletes;

    protected $table = 'tagihan_spp';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_santri', 'bulan', 'tahun', 'biaya_makan', 'biaya_listrik',
        'biaya_sosial', 'biaya_ianah', 'total_tagihan', 'status_tagihan'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranSpp::class, 'id_tagihan');
    }
}
