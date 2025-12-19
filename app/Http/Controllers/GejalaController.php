<?php

namespace App\Http\Controllers; // Namespace umum

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Logika Pengambilan Data (Sama untuk semua user)
        $query = Gejala::query();

        if ($request->has('search')) {
            $query->where('gejala', 'like', '%' . $request->search . '%')
                ->orWhere('kode', 'like', '%' . $request->search . '%');
        }

        $gejalas = $query->orderBy('kode', 'asc')->paginate(10);

        // 2. Logika Pemilihan View Berdasarkan Role
        $user = Auth::user();

        // Cek Role dan arahkan ke view yang sesuai
        if ($user->roles()->where('name', 'admin')->exists()) {
            // Jika Admin -> Tampilan Admin (mungkin ada tombol edit/hapus)
            return view('admin.gejala.index', compact('gejalas'));
        } elseif ($user->roles()->where('name', 'penyuluh')->exists()) {
            // Jika Pakar -> Tampilan Pakar
            return view('pakar.gejala.index', compact('gejalas'));
        } else {
            // Jika Petani (Default) -> Tampilan Petani
            return view('petani.gejala.index', compact('gejalas'));
        }
    }

    public function storeAjax(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'kode'   => 'required|unique:gejalas,kode|max:10',
            'gejala' => 'required|string|max:255',
            'bagian' => 'required|in:daun,batang_pucuk,biji_gabah,umum', // Validasi kategori
        ], [
            // Validasi Kode
            'kode.required' => 'Kode gejala wajib diisi.',
            'kode.unique'   => 'Kode gejala ini sudah terdaftar, gunakan kode lain.',
            'kode.max'      => 'Kode gejala maksimal 10 karakter.',

            // Validasi Nama Gejala
            'gejala.required' => 'Nama gejala wajib diisi.',
            'gejala.string'   => 'Nama gejala harus berupa teks.',
            'gejala.max'      => 'Nama gejala maksimal 255 karakter.',

            // Validasi Bagian Tanaman
            'bagian.required' => 'Bagian tanaman wajib dipilih.',
            'bagian.in'       => 'Pilihan bagian tanaman tidak valid (Pilih: Daun, Batang/Pucuk, Biji/Gabah, atau Umum).',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // 2. Simpan ke Database
            $gejala = Gejala::create([
                'kode'   => $request->kode,
                'gejala' => $request->gejala,
                'bagian' => $request->bagian, // Simpan kategorinya
            ]);

            // 3. Kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Gejala berhasil ditambahkan!',
                'gejala'  => $gejala
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 500);
        }
    }
}
