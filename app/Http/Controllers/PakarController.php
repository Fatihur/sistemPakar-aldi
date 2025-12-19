<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PakarController extends Controller
{
    //
    /**
     * Menampilkan halaman edit profil pakar.
     */
    public function edit()
    {
        // Arahkan ke view 'pakar.profile'
        return view('pakar.profile');
    }

    /**
     * Memperbarui informasi profil pakar.
     */
    public function update(Request $request)
    {
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
            'username.unique'   => 'Username ini sudah digunakan oleh pengguna lain.',
            'username.max'      => 'Username tidak boleh lebih dari 255 karakter.',

            // Validasi Email
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah terdaftar, silakan gunakan email lain.',

            // Validasi Password
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password baru minimal harus terdiri dari 8 karakter.',
        ]);

        // Perbarui data pengguna
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        // Perbarui kata sandi jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Arahkan kembali ke halaman edit profil dengan pesan sukses
        return redirect()->route('pakar.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
