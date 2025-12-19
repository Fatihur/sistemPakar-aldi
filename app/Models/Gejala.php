<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'gejala',
        'bagian',
    ];

    /**
     * DITAMBAHKAN:
     * Relasi Many-to-Many ke Penyakit.
     */
    public function penyakits()
    {
        return $this->belongsToMany(Penyakit::class, 'gejala_penyakit');
    }
}