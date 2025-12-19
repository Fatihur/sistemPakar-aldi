<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,id',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Update data pengguna
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Update kata sandi jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sinkronkan peran (role) pengguna
        $user->roles()->sync($request->role);

        return redirect()->route('admin.users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Menampilkan daftar semua pengguna dengan fitur pencarian dan paginasi.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('roles') // Eager load relasi roles
            ->when($search, function ($query, $search) {
                // Logika pencarian berdasarkan nama, username, atau email
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Paginasi 10 item per halaman
        $totalUsers = User::count();
        return view('admin.pengguna', compact('users', 'totalUsers'));
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Untuk keamanan, jangan biarkan admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }


    /**
     * Menampilkan formulir untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Ambil semua peran untuk ditampilkan di dropdown
        return view('admin.edit', compact('user', 'roles'));
    }

    /**
     * DITAMBAHKAN: Menampilkan formulir untuk membuat pengguna baru.
     */
    public function create()
    {
        $roles = Role::all(); // Ambil semua peran untuk ditampilkan di dropdown
        return view('admin.create', compact('roles'));
    }

    /**
     * DITAMBAHKAN: Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|exists:roles,id',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            // Validasi Nama
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string'   => 'Nama harus berupa teks.',
            'name.max'      => 'Nama tidak boleh lebih dari 255 karakter.',

            // Validasi Username
            'username.required' => 'Username wajib diisi.',
            'username.string'   => 'Username harus berupa teks.',
            'username.max'      => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique'   => 'Username ini sudah digunakan, silakan pilih yang lain.',

            // Validasi Email
            'email.required' => 'Alamat email wajib diisi.',
            'email.string'   => 'Email harus berupa teks.',
            'email.email'    => 'Format email tidak valid.',
            'email.max'      => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique'   => 'Email ini sudah terdaftar dalam sistem.',

            // Validasi Role
            'role.required' => 'Role (peran) pengguna wajib dipilih.',
            'role.exists'   => 'Pilihan role tidak valid.',

            // Validasi Password
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus terdiri dari 8 karakter.',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tetapkan peran (role) untuk pengguna baru
        $user->roles()->attach($request->role);

        return redirect()->route('admin.users.index')->with('success', "Pengguna baru {$user->name} berhasil ditambahkan.");
    }
}
