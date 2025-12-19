<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function index()
    {
        return view('login.login'); // Pastikan path view Anda benar
    }

    /**
     * Menangani upaya otentikasi.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'username' => ['required',
            'string'],
            'password' => ['required'],
        ], [
            'username.required' => 'Silakan masukan username Anda.',
            'password.required' => 'Silakan masukan password Anda.',
        ]);

        // Mengambil nilai "Remember Me"
        $remember = $request->boolean('remember');

        // 2. Mencoba untuk melakukan login
        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // 3. Cek peran pengguna dan arahkan ke dasbor yang sesuai
            $user = Auth::user();
            $role = $user->roles()->first()->name;

            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'penyuluh':
                    return redirect()->route('pakar.dashboard');
                case 'petani':
                default:
                    return redirect()->route('petani.dashboard');
            }
        }

        // 4. Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan tidak valid.',
        ])->onlyInput('username');
    }



    /**
     * Menangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session agar tidak bisa di-back browser
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); //->with('success', 'Berhasil keluar dari aplikasi.')
    }
}
