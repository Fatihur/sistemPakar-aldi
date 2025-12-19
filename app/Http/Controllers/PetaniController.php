<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PetaniController extends Controller
{
    //
    public function edit()
    {
        // Arahkan ke view 'petani.profile' yang sudah Anda buat
        return view('petani.profile');
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            // Validasi Nama
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string'   => 'Nama harus berupa teks.',
            'name.max'      => 'Nama tidak boleh lebih dari 255 karakter.',

            // Validasi Username
            'username.required' => 'Username wajib diisi.',
            'username.string'   => 'Username harus berupa teks.',
            'username.unique'   => 'Username ini sudah digunakan oleh pengguna lain.',
            'username.max'      => 'Username tidak boleh lebih dari 255 karakter.',

            // Validasi Email
            'email.required' => 'Alamat email wajib diisi.',
            'email.string'   => 'Email harus berupa teks.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'email.max'      => 'Email tidak boleh lebih dari 255 karakter.',

            // Validasi Password
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password baru minimal harus terdiri dari 8 karakter.',
        ]);

        // Perbarui nama dan email
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Perbarui kata sandi jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();

        // Arahkan kembali ke halaman edit profil dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Data profil Anda berhasil diperbarui!');
    }
}
