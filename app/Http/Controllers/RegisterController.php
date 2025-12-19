<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Ambil ID peran 'petani' secara otomatis
        // firstOrFail() akan menyebabkan error jika role 'petani' tidak ada,
        // ini bagus untuk memastikan sistem terkonfigurasi dengan benar.
        $role_petani_id = Role::where('name', 'petani')->firstOrFail()->id;

        // Kirim ID ke view untuk digunakan di hidden input
        return view('login.register', compact('role_petani_id'));
    }

    /**
     * Menangani permintaan registrasi dari form.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required', 'integer', 'exists:roles,id'], // Validasi hidden input
            ],
            [
                // Validasi Nama
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.string'   => 'Nama harus berupa teks.',
                'name.max'      => 'Nama tidak boleh lebih dari 255 karakter.',

                // Validasi Username
                'username.required' => 'Username wajib diisi.',
                'username.unique'   => 'Username ini sudah digunakan, silakan pilih yang lain.',
                'username.max'      => 'Username maksimal 255 karakter.',

                // Validasi Email
                'email.required' => 'Alamat email wajib diisi.',
                'email.email'    => 'Format email tidak valid (contoh: user@email.com).',
                'email.unique'   => 'Email ini sudah terdaftar di sistem.',

                // Validasi Password
                'password.required'  => 'Password wajib diisi.',
                'password.min'       => 'Password minimal harus terdiri dari 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',

                // Validasi Role
                'role_id.required' => 'Role pengguna wajib dipilih.',
                'role_id.exists'   => 'Role yang dipilih tidak valid.',
            ]
        );

        // 2. Buat pengguna baru di database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Kaitkan pengguna yang baru dibuat dengan peran 'petani'
        $user->roles()->attach($request->role_id);

        // 4. Login otomatis dinonaktifkan. Pengguna akan diarahkan ke halaman login.
        // Auth::login($user);

        // 5. Arahkan pengguna ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');
    }
}
