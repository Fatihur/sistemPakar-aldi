<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data peran (roles) awal.
     *
     * @return void
     */
    public function run(): void
    {
        // Daftar peran yang akan dibuat untuk sistem pakar penyakit padi
        $roles = [
            [
                'name' => 'petani', // Diubah dari 'pasien'
                'display_name' => 'Petani',
                'description' => 'Pengguna yang melakukan konsultasi diagnosa penyakit padi.',
            ],
            [
                'name' => 'penyuluh',
                'display_name' => 'penyuluh Pertanian', // Lebih spesifik dari 'Pakar / Dokter'
                'description' => 'Ahli yang mengelola basis pengetahuan, aturan, dan solusi.',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Pengguna dengan hak akses penuh untuk mengelola sistem dan pengguna.',
            ],
        ];

        // Looping untuk membuat atau memperbarui setiap peran
        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']], // Kunci untuk mencari
                [
                    'display_name' => $roleData['display_name'],
                    'description' => $roleData['description'],
                ] // Nilai yang akan dibuat atau di-update
            );
        }
    }
}