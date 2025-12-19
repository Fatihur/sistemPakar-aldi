<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PakarUserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (versi read-only).
     */
    public function index(Request $request)
    {
        // 1. Filter hanya user yang punya role 'petani'
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'petani');
        });

        // 2. Fitur Pencarian (Opsional)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data dengan paginasi
        $users = $query->latest()->paginate(10);

        return view('pakar.users', compact('users'));
    }
}
