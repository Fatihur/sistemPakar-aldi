<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solusi extends Model
{
    //
    protected $fillable = [
        'kode',
        'nama_obat',
        'gambar_obat' 
    ];
}
