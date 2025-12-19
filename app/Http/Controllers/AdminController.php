<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Menampilkan halaman edit profil admin.
     */
    public function edit()
    {
        // Arahkan ke view 'admin.profile'
        return view('admin.profile');
    }

    /**
     * Memperbarui informasi profil admin.
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
            'username.string'   => 'Username harus berupa teks.',
            'username.max'      => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique'   => 'Username ini sudah digunakan oleh pengguna lain.',

            // Validasi Email
            'email.required' => 'Alamat email wajib diisi.',
            'email.string'   => 'Email harus berupa teks.',
            'email.email'    => 'Format email tidak valid.',
            'email.max'      => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique'   => 'Email ini sudah terdaftar oleh pengguna lain.',

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
        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
