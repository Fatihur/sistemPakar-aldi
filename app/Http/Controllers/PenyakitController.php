<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyakit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class PenyakitController extends Controller
{
    //
    public function index(Request $request)
    {
        Paginator::useBootstrapFive();
        $search = $request->input('search');

        $penyakits = Penyakit::when($search, function ($query, $search) {
                                // Logika pencarian berdasarkan nama atau kode
                                return $query->where('nama_penyakit', 'like', "%{$search}%")
                                             ->orWhere('kode', 'like', "%{$search}%");
                            })
                            
                            ->orderBy('created_at', 'asc')
                            ->paginate(10); // Paginasi 10 item per halaman

        $user = Auth::user();

        if ($user->roles()->where('name', 'admin')->exists()) {
            // Jika Admin, tampilkan view admin
            return view('admin.penyakit', compact('penyakits'));
            
        } elseif ($user->roles()->where('name', 'penyuluh')->exists()) {
            // Jika Pakar, tampilkan view pakar
            return view('pakar.penyakit', compact('penyakits'));
            
        } else {
            // Jika bukan keduanya (asumsi Petani), tampilkan view petani
            return view('petani.penyakit', compact('penyakits'));
        }
    
    }
}
