<?php

namespace App\Models;

use App\Models\User;
use App\Models\TagihanSpp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranSpp extends Model
{
    use SoftDeletes;

    protected $table = 'pembayaran_spp';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_tagihan', 'jumlah_bayar', 'tanggal_bayar', 'bukti_pembayaran',
        'metode_pembayaran', 'bank_pengirim', 'nama_pengirim',
        'status_verifikasi', 'diverifikasi_oleh', 'tanggal_verifikasi', 'keterangan'
    ];

    public function tagihan()
    {
        return $this->belongsTo(TagihanSpp::class, 'id_tagihan');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
