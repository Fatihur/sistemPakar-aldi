<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use App\Models\Gejala; // <-- Import model Gejala

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert data awal gejala
        DB::table('gejalas')->insert([
            ['kode' => 'G01', 'gejala' => 'Tepi daun memiliki bentuk seperti garis garis bergelombang dengan warna kuning', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G02', 'gejala' => 'Bercak bercak kecil, berwarna hingga kehitaman', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G03', 'gejala' => 'Kerusakan pada jaringan daun', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G04', 'gejala' => 'Perubahan warna daun menjadi putih', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G05', 'gejala' => 'Tanaman padi tumbuh tidak normal dengan batang yang kurang kokoh dan daun yang kurang subur', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G06', 'gejala' => 'Pucuk tanaman layu, mengering dan mati akibat larva merusak bagian Tengah anakan', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G07', 'gejala' => 'Tanaman mengering dan mati', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G08', 'gejala' => 'Perubahan warna daun menjadi belang', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G09', 'gejala' => 'Muncul bercak kuning atau oren pada daun', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G10', 'gejala' => 'Daun padi layu dan mengguning', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G11', 'gejala' => 'Kerusakan pada biji padi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G12', 'gejala' => 'Kerusakan pada daun padi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G13', 'gejala' => 'Kerusakan pada batang', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G14', 'gejala' => 'Pertumbuhan tanaman melambat', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G15', 'gejala' => 'Penurunan hasil panen padi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G16', 'gejala' => 'Penurunan anak padi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G17', 'gejala' => 'Tanaman kerdil dengan anakan dan bulir berkurang', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G18', 'gejala' => 'Kerusakan pada buah', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G19', 'gejala' => 'Daun menggulung dan berubah warna', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G20', 'gejala' => 'Perubahan daun menjadi putih', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G21', 'gejala' => 'Kualitas biji padi jelek', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G22', 'gejala' => 'Kodisi gabah kosong atau hampah', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G23', 'gejala' => 'Penurunan jumlah anakan', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G24', 'gejala' => 'Gabah Kusam', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G25', 'gejala' => 'Bercak pada bagian bawah pelepah padi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G26', 'gejala' => 'Tanaman mudah rebah', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G27', 'gejala' => 'Daun pelepah mengering', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Mapping kategori berdasarkan kode gejala
        $mapping = [
            'daun' => ['G01','G02','G03','G04','G08','G09','G10','G12','G19','G20','G27'],
            'batang_pucuk' => ['G05','G06','G13','G25','G26'],
            'biji_gabah' => ['G11','G18','G21','G22','G24'],
            'umum' => ['G07','G14','G15','G16','G17','G23'],
        ];

        // Loop dan update kategori
        foreach ($mapping as $kategori => $daftarKode) {
            Gejala::whereIn('kode', $daftarKode)->update(['bagian' => $kategori]);
            $this->command->info("Berhasil update kategori: $kategori");
        }

        // Set 'umum' untuk data yang belum ada bagian
        Gejala::whereNull('bagian')->update(['bagian' => 'umum']);
    }
}
