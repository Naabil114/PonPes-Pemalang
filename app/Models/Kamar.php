<?php

namespace App\Models;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use SoftDeletes;

    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';

    protected $fillable = ['nama_kamar', 'jenis_kelamin', 'kapasitas', 'status'];

    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_kamar');
    }
}
