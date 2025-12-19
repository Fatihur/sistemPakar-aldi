<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'Budi Petani',
                'username' => 'petani1',
                'email' => 'petani1@example.com',
                'password' => 'password123',
                'role' => 'petani',
            ],
            [
                'name' => 'Busairi',
                'username' => 'penyuluh1',
                'email' => 'pakar1@example.com',
                'password' => 'password123',
                'role' => 'penyuluh',
            ],
            [
                'name' => 'Admin Sistem',
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ],
        ];

        foreach ($usersData as $userData) {
            // Gunakan updateOrCreate untuk mencegah error duplikasi
            $user = User::updateOrCreate(
                // Kunci untuk mencari pengguna (harus unik)
                ['username' => $userData['username']],
                // Data yang akan dibuat atau di-update
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                ]
            );

            $role = Role::where('name', $userData['role'])->first();

            // syncRoles() lebih aman, ia akan menghapus role lama dan menambahkan yang baru
            if ($user && $role) {
                $user->roles()->sync($role->id);
            }
        }
    }
}
