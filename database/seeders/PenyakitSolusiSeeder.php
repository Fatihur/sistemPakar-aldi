<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit;
use App\Models\Solusi;

class PenyakitSolusiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penyakit_solusi')->truncate();
        
        // Ambil data dari tabel untuk dicocokkan
        $penyakits = Penyakit::all()->keyBy('kode');
        $solusis = Solusi::all()->keyBy('nama_obat');

        $relasi = [
            'P01' => ['Score', 'Amistartop', 'Nordoc', 'Sultricob'],
            'P02' => ['Incipio', 'Virtako', 'Spontan', 'Trisula', 'Kamikase'],
            'P03' => ['Incipio', 'Virtako', 'Dangke', 'Chix'], // Icipio -> Incipio
            'P04' => ['Vestoria', 'Plenum', 'Incipio'],
            'P05' => ['Vestoria', 'Plenum', 'Virtako'], // Virtaco -> Virtako
            'P06' => ['Vestoria', 'Plenum', 'Confidor'],
            'P07' => ['Vestoria', 'Plenum', 'Virtako'], // Virtaco -> Virtako
            'P08' => ['Filia', 'Topsim', 'Topsida', 'Score', 'Starplus'],
            'P09' => ['Filia', 'Topsin', 'Topsida', 'Envoy'],
            'P10' => ['Plenum', 'Alika', 'Dangke', 'Chix'],
            'P11' => ['Amistartop', 'Regen', 'Antracol'], // P11 jadi Hawar Pelepah
            'P12' => ['Amistartop', 'Nordoc', 'Baktosin', 'Sultricop', 'Puanmore'], // P12 jadi Hawar Bakteri
        ];

        $dataToInsert = [];
        foreach ($relasi as $kodePenyakit => $daftarObat) {
            foreach ($daftarObat as $namaObat) {
                // Pastikan penyakit dan solusi ada sebelum membuat relasi
                if (isset($penyakits[$kodePenyakit]) && isset($solusis[$namaObat])) {
                    $dataToInsert[] = [
                        'penyakit_id' => $penyakits[$kodePenyakit]->id,
                        'solusi_id' => $solusis[$namaObat]->id,
                    ];
                }
            }
        }
        
        DB::table('penyakit_solusi')->insert($dataToInsert);
    }
}