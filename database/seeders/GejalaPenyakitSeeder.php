<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit;
use App\Models\Gejala;

class GejalaPenyakitSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kosongkan tabel pivot
        DB::table('gejala_penyakit')->truncate();
        
        // 2. Ambil semua data master
        $penyakits = Penyakit::all()->keyBy('kode');
        $gejalas = Gejala::all()->keyBy('kode');

        // 3. Definisikan aturan (Basis Pengetahuan) dari tabel Anda
        $rules = [
            'P01' => ['G01', 'G02', 'G03', 'G04'],
            'P02' => ['G05', 'G06', 'G07', 'G08', 'G09'],
            'P03' => ['G10', 'G11', 'G12', 'G13'],
            'P04' => ['G02', 'G10', 'G07', 'G14', 'G15', 'G16'],
            'P05' => ['G12', 'G17', 'G18'],
            'P06' => ['G03', 'G19', 'G13'],
            'P07' => ['G03', 'G08', 'G14', 'G04', 'G15', 'G21'],
            'P08' => ['G12', 'G18', 'G09', 'G22'],
            'P09' => ['G12', 'G18', 'G14', 'G23'],
            'P10' => ['G14', 'G22', 'G23', 'G21'],
            'P11' => ['G15', 'G24', 'G09'],
            'P12' => ['G25', 'G26', 'G27'],
        ];

        // 4. Siapkan data untuk dimasukkan ke tabel pivot
        $dataToInsert = [];
        foreach ($rules as $kodePenyakit => $daftarGejala) {
            foreach ($daftarGejala as $kodeGejala) {
                // Pastikan kode penyakit dan gejalanya ada di database
                if (isset($penyakits[$kodePenyakit]) && isset($gejalas[$kodeGejala])) {
                    $dataToInsert[] = [
                        'penyakit_id' => $penyakits[$kodePenyakit]->id,
                        'gejala_id' => $gejalas[$kodeGejala]->id,
                    ];
                }
            }
        }
        
        // 5. Masukkan semua relasi aturan ke database
        DB::table('gejala_penyakit')->insert($dataToInsert);
    }
}