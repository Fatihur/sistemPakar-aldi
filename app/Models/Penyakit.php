<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    //
    protected $fillable = [
        'kode',
        'nama_penyakit',
        'gambar', 
        'p_c',
    ];

    public function solusis()
    {
        return $this->belongsToMany(Solusi::class, 'penyakit_solusi');
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'gejala_penyakit');
    }
}
