<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    

    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';

    protected $fillable = ['no_rek',  'nama_rek'];

   
}
