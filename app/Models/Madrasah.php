<?php

namespace App\Models;

use App\Models\Santri;
use App\Models\KomponenSpp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Madrasah extends Model
{
    use SoftDeletes;

    protected $table = 'madrasah';
    protected $primaryKey = 'id_madrasah';

    protected $fillable = ['nama_madrasah', 'deskripsi'];

    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_madrasah');
    }

    public function komponenSpp()
    {
        return $this->hasMany(KomponenSpp::class, 'id_madrasah');
    }
}
