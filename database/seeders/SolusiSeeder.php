<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolusiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('solusis')->truncate();

        $solusiData = [
            ['kode' => 'KO01', 'nama_obat' => 'Score', 'gambar_obat' => 'obat/score.jpg'],
            ['kode' => 'KO02', 'nama_obat' => 'Amistartop', 'gambar_obat' => 'obat/amistartop.jpg'],
            ['kode' => 'KO03', 'nama_obat' => 'Nordoc', 'gambar_obat' => 'obat/nordox.png'],
            ['kode' => 'KO04', 'nama_obat' => 'Sultricob', 'gambar_obat' => 'obat/sultricob.jpg'],
            ['kode' => 'KO05', 'nama_obat' => 'Incipio', 'gambar_obat' => 'obat/incipio.jpg'],
            ['kode' => 'KO06', 'nama_obat' => 'Virtako', 'gambar_obat' => 'obat/virtako.png'],
            ['kode' => 'KO07', 'nama_obat' => 'Spontan', 'gambar_obat' => 'obat/spontan.jpg'],
            ['kode' => 'KO08', 'nama_obat' => 'Trisula', 'gambar_obat' => 'obat/trisula.jpeg'],
            ['kode' => 'KO09', 'nama_obat' => 'Kamikase', 'gambar_obat' => 'obat/kamikase.png'],
            ['kode' => 'KO10', 'nama_obat' => 'Dangke', 'gambar_obat' => 'obat/dangke.jpg'],
            ['kode' => 'KO11', 'nama_obat' => 'Chix', 'gambar_obat' => 'obat/chix.png'],
            ['kode' => 'KO12', 'nama_obat' => 'Vestoria', 'gambar_obat' => 'obat/vestoria.jpeg'],
            ['kode' => 'KO13', 'nama_obat' => 'Plenum', 'gambar_obat' => 'obat/plenum.png'],
            ['kode' => 'KO14', 'nama_obat' => 'Confidor', 'gambar_obat' => 'obat/confidor.jpg'],
            ['kode' => 'KO15', 'nama_obat' => 'Filia', 'gambar_obat' => 'obat/filia.jpg'],
            ['kode' => 'KO16', 'nama_obat' => 'Topsim', 'gambar_obat' => 'obat/Topsim.jpg'],
            ['kode' => 'KO17', 'nama_obat' => 'Topsida', 'gambar_obat' => 'obat/topsida.jpg'],
            ['kode' => 'KO18', 'nama_obat' => 'Starplus', 'gambar_obat' => 'obat/starplus.jpeg'],
            ['kode' => 'KO19', 'nama_obat' => 'Envoy', 'gambar_obat' => 'obat/envoy.png'],
            ['kode' => 'KO20', 'nama_obat' => 'Alika', 'gambar_obat' => 'obat/alika.jpg'],
            ['kode' => 'KO21', 'nama_obat' => 'Regen', 'gambar_obat' => 'obat/regent.jpg'],
            ['kode' => 'KO22', 'nama_obat' => 'Antracol', 'gambar_obat' => 'obat/antracol.jpg'],
            ['kode' => 'KO23', 'nama_obat' => 'Baktosin', 'gambar_obat' => 'obat/bactocyn.jpg'],
            ['kode' => 'KO24', 'nama_obat' => 'Puanmur', 'gambar_obat' => 'obat/puanmur.jpg'],
            ['kode' => 'KO25', 'nama_obat' => 'Topsin', 'gambar_obat' => 'obat/topsin.jpeg'], // Topsin pakai gambar topsim
        ];
        
        DB::table('solusis')->insert($solusiData);
    }
}
