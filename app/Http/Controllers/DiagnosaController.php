<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\Penyakit; // Model ini digunakan di method 'calculate'
use Illuminate\Support\Str;
use App\Models\User;


class DiagnosaController extends Controller
{
    /**
     * Menampilkan halaman form diagnosis (wizard).
     */
    public function index()
    {
        // 1. Ambil semua gejala dari database
        $semuaGejala = Gejala::all();

        // 2. Tentukan kode untuk setiap kategori
        $gejalaDaun   = $semuaGejala->where('bagian', 'daun');
        $gejalaBatang = $semuaGejala->where('bagian', 'batang_pucuk');
        $gejalaBiji   = $semuaGejala->where('bagian', 'biji_gabah');
        $gejalaUmum   = $semuaGejala->where('bagian', 'umum');

        // 4. Kirim data yang sudah dikelompokkan ke view
        $user = auth()->user();
        $viewName = 'petani.diagnosa'; // Default

        if ($user->roles()->where('name', 'admin')->exists()) {
            $viewName = 'admin.diagnosa';
        } elseif ($user->roles()->where('name', 'penyuluh')->exists()) {
            $viewName = 'pakar.diagnosa';
        }

        return view($viewName, compact('gejalaDaun', 'gejalaBatang', 'gejalaBiji', 'gejalaUmum'));
    }

    /**
     * Menerima data dari form dan menghitung hasil diagnosis.
     * (Logika Naive Bayes ada di sini)
     */
    public function calculate(Request $request)
    {
        // ... (Logika Naive Bayes lengkap dari respons saya sebelumnya ada di sini) ...
        
        // 1. Ambil gejala yang dipilih pengguna
        $gejalaTerpilih = $request->input('gejala');
        if (empty($gejalaTerpilih)) {
            return back()->with('error', 'Anda belum memilih gejala apapun.');
        }

        // 2. Ambil data dari database
        $penyakits = Penyakit::with('gejalas')->get();
        $gejalasFromDb = Gejala::whereIn('kode', $gejalaTerpilih)->get();
        
        // 3. Tentukan parameter Naive Bayes
        $m = Gejala::count(); // m = 27
        $a = 1; // Laplace smoothing

        $unnormalizedPosteriors = [];
        $P_X_C_values = [];

        // 4. Hitung P(X|C) * P(C) untuk setiap penyakit
        foreach ($penyakits as $penyakit) {
            $n = $penyakit->gejalas->count();
            $P_X_C = 1.0;
            $P_C = (float) $penyakit->p_c;
            $gejalaCodesForThisPenyakit = $penyakit->gejalas->pluck('kode')->toArray();

            foreach ($gejalaTerpilih as $gejalaCode) {
                $Nc = in_array($gejalaCode, $gejalaCodesForThisPenyakit) ? 1 : 0;
                $P_Xi_C = ($Nc + $a) / ($n + $m);
                $P_X_C *= $P_Xi_C;
            }
            
            $P_X_C_values[$penyakit->id] = $P_X_C;
            $unnormalizedPosteriors[$penyakit->id] = $P_X_C * $P_C;
        }

        // 5. Hitung Total P(X)
        $P_X = array_sum($unnormalizedPosteriors);

        // 6. Hitung Probabilitas Posterior P(C|X) (Normalisasi)
        $normalizedResults = [];
        foreach ($unnormalizedPosteriors as $penyakitId => $prob) {
            $normalizedResults[$penyakitId] = ($P_X > 0) ? (($prob / $P_X) * 100) : 0;
        }
        
        arsort($normalizedResults); // Urutkan

        // 8. Siapkan data untuk dikirim ke view
        $fullResults = [];
        foreach ($normalizedResults as $penyakitId => $prob) {
            $fullResults[] = [
                'penyakit' => $penyakits->find($penyakitId),
                'probabilitas' => $prob,
                'p_x_c' => $P_X_C_values[$penyakitId],
            ];
        }
        
        $winnerId = array_key_first($normalizedResults);
        $winnerPenyakit = Penyakit::with('solusis')->find($winnerId);
        $winnerConfidence = $normalizedResults[$winnerId];

        // 9. KIRIM DATA KE TAMPILAN HASIL DIAGNOSIS
        $viewData = [
            'winner' => $winnerPenyakit,
            'confidence' => $winnerConfidence,
            'fullResults' => $fullResults,
            'gejalaTerpilih' => $gejalasFromDb,
            'P_X' => $P_X,
        ];

        if (auth()->user()->roles()->where('name', 'admin')->exists()) {
            return view('admin.hasil_diagnosa', $viewData);
        } elseif (auth()->user()->roles()->where('name', 'penyuluh')->exists()) {
            return view('pakar.hasil_diagnosa', $viewData);
        } else {
            // Default untuk Petani
            return view('petani.hasil_diagnosa', $viewData);
        }
    }
}