<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penyakits')->truncate();
        
        DB::table('penyakits')->insert([
            ['kode' => 'P01', 'nama_penyakit' => 'Hawar Daun Bakteeri', 'gambar' => 'images/penyakit/p01.jpg', 'p_c' => 0.081632653, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P02', 'nama_penyakit' => 'Penggerak Batang', 'gambar' => 'images/penyakit/p02.jpg', 'p_c' => 0.102040816, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P03', 'nama_penyakit' => 'Hamah Ulat Buah', 'gambar' => 'images/penyakit/p03.jpeg', 'p_c' => 0.081632653, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P04', 'nama_penyakit' => 'Wereng Coklat', 'gambar' => 'images/penyakit/p04.jpg', 'p_c' => 0.122448979, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P05', 'nama_penyakit' => 'Penyakit Tungro', 'gambar' => 'images/penyakit/p05.png', 'p_c' => 0.061224489, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P06', 'nama_penyakit' => 'Hama Trips', 'gambar' => 'images/penyakit/p06.jpeg', 'p_c' => 0.061224489, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P07', 'nama_penyakit' => 'Wereng Hijau', 'gambar' => 'images/penyakit/p07.jpg', 'p_c' => 0.122448979, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P08', 'nama_penyakit' => 'Karat Daun', 'gambar' => 'images/penyakit/p08.jpeg', 'p_c' => 0.081632653, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P09', 'nama_penyakit' => 'Bercak Daun Coklat', 'gambar' => 'images/penyakit/p09.jpeg', 'p_c' => 0.081632653, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P10', 'nama_penyakit' => 'Walang Sangit', 'gambar' => 'images/penyakit/p10.png', 'p_c' => 0.081632653, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P11', 'nama_penyakit' => 'Hawar Bakteri', 'gambar' => 'images/penyakit/p11.jpg', 'p_c' => 0.061224489, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'P12', 'nama_penyakit' => 'Hawar Pelepah', 'gambar' => 'images/penyakit/p12.jpg', 'p_c' => 0.061224489, 'created_at' => now(), 'updated_at' => now()],
        ]);

        
    }
}