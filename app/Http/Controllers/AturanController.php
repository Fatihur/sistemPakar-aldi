<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Solusi;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AturanController extends Controller
{
    /**
     * Menampilkan daftar semua penyakit dan gejalanya (aturan).
     */
    public function index(Request $request)
    {
        Paginator::useBootstrapFive();
        $search = $request->input('search');
        $penyakits = Penyakit::with('gejalas')
            ->when($search, function ($query, $search) {
                return $query->where('nama_penyakit', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.aturan.index', compact('penyakits'));
    }

    /**
     * BARU: Menampilkan form untuk membuat penyakit baru
     */
    public function create()
    {
        $semuaGejala = Gejala::orderBy('kode')->get();
        $semuaSolusi = Solusi::orderBy('kode')->get();

        return view('admin.aturan.create', compact('semuaGejala', 'semuaSolusi'));
    }

    /**
     * BARU: Menyimpan penyakit baru beserta relasinya
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:penyakits',
            'nama_penyakit' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Asumsi path diisi manual, atau ubah jadi 'image' jika upload
            'gejala_ids' => 'required|array|min:1', // Harus pilih minimal 1 gejala
            'solusi_ids' => 'required|array|min:1', // Harus pilih minimal 1 solusi
        ], [
            // Validasi Kode
            'kode.required' => 'Kode penyakit wajib diisi.',
            'kode.max'      => 'Kode penyakit maksimal 10 karakter.',
            'kode.unique'   => 'Kode penyakit ini sudah terdaftar, gunakan kode lain.',

            // Validasi Nama Penyakit
            'nama_penyakit.required' => 'Nama penyakit wajib diisi.',
            'nama_penyakit.max'      => 'Nama penyakit maksimal 255 karakter.',

            // Validasi Gambar
            'gambar.required' => 'Gambar penyakit wajib di isi.',
            'gambar.image' => 'File yang diupload harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'   => 'Ukuran gambar tidak boleh lebih dari 2MB.',

            // Validasi Pilihan Gejala (Array)
            'gejala_ids.required' => 'Anda harus memilih minimal satu gejala.',
            'gejala_ids.array'    => 'Format data gejala tidak valid.',
            'gejala_ids.min'      => 'Silakan pilih minimal 1 gejala dari daftar.',

            // Validasi Pilihan Solusi (Array)
            'solusi_ids.required' => 'Anda harus memilih minimal satu solusi/obat.',
            'solusi_ids.array'    => 'Format data solusi tidak valid.',
            'solusi_ids.min'      => 'Silakan pilih minimal 1 solusi/obat dari daftar.',
        ]);

        $dbPath = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // Buat nama file unik
            $filename = time() . '_' . $file->getClientOriginalName();

            // Pindahkan file ke folder: public/penyakit
            $file->move(public_path('penyakit'), $filename);

            // Path yang disimpan di database
            $dbPath = 'penyakit/' . $filename;
        }


        $penyakit = Penyakit::create([
            'kode' => $request->kode,
            'nama_penyakit' => $request->nama_penyakit,
            'gambar' => $dbPath, // Simpan path baru
        ]);

        // 2. Hubungkan Gejala (Aturan)
        $penyakit->gejalas()->sync($request->gejala_ids);

        // 3. Hubungkan Solusi
        $penyakit->solusis()->sync($request->solusi_ids);

        // 4. Hitung ulang SEMUA nilai P(c)
        $this->recalculatePc();

        return redirect()->route('admin.aturan.index')->with('success', 'Penyakit baru berhasil ditambahkan dan P(c) telah diperbarui.');
    }


    /**
     * Menampilkan form untuk mengedit aturan (gejala) dari suatu penyakit.
     */
    public function edit(string $id)
    {
        $penyakit = Penyakit::with(['gejalas', 'solusis'])->findOrFail($id);
        $semuaGejala = Gejala::orderBy('kode')->get();
        $semuaSolusi = Solusi::orderBy('kode')->get();

        // Ambil ID relasi yang sudah ada
        $gejalaDimiliki = $penyakit->gejalas->pluck('id')->toArray();
        $solusiDimiliki = $penyakit->solusis->pluck('id')->toArray();

        return view('admin.aturan.edit', compact('penyakit', 'semuaGejala', 'semuaSolusi', 'gejalaDimiliki', 'solusiDimiliki'));
    }

    public function show(string $id)
    {
        $penyakit = Penyakit::with(['gejalas', 'solusis'])
            ->findOrFail($id);

        return view('admin.aturan.show', compact('penyakit'));
    }

    /**
     * Menyimpan perubahan aturan dari form edit.
     */
    public function update(Request $request, string $id)
    {
        $penyakit = Penyakit::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:penyakits,kode,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gejala_ids' => 'required|array|min:1',
            'solusi_ids' => 'required|array|min:1',
        ], [
            // Validasi Kode
            'kode.required' => 'Kode penyakit wajib diisi.',
            'kode.string'   => 'Kode penyakit harus berupa teks.',
            'kode.max'      => 'Kode penyakit tidak boleh lebih dari 10 karakter.',
            'kode.unique'   => 'Kode penyakit ini sudah digunakan, silakan ganti dengan yang lain.',

            // Validasi Nama Penyakit
            'nama_penyakit.required' => 'Nama penyakit wajib diisi.',
            'nama_penyakit.string'   => 'Nama penyakit harus berupa teks.',
            'nama_penyakit.max'      => 'Nama penyakit tidak boleh lebih dari 255 karakter.',

            // Validasi Gambar
            'gambar.image' => 'File yang diupload harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'   => 'Ukuran gambar tidak boleh lebih dari 2MB.',

            // Validasi Gejala
            'gejala_ids.required' => 'Anda wajib memilih minimal satu gejala.',
            'gejala_ids.array'    => 'Format data gejala tidak valid.',
            'gejala_ids.min'      => 'Silakan pilih minimal 1 gejala dari daftar.',

            // Validasi Solusi
            'solusi_ids.required' => 'Anda wajib memilih minimal satu solusi/obat.',
            'solusi_ids.array'    => 'Format data solusi tidak valid.',
            'solusi_ids.min'      => 'Silakan pilih minimal 1 solusi/obat dari daftar.',
        ]);

        // 1. Default path adalah gambar yang lama
        $imagePath = $penyakit->gambar;

        // 2. Cek apakah ada upload gambar BARU
        if ($request->hasFile('gambar')) {

            // A. Hapus gambar lama jika ada di folder public/penyakit
            // Cek apakah path lama tidak null DAN file fisiknya ada
            if ($penyakit->gambar && File::exists(public_path($penyakit->gambar))) {
                File::delete(public_path($penyakit->gambar));
            }

            // B. Proses simpan gambar baru ke public/penyakit
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Pindahkan file
            $file->move(public_path('penyakit'), $filename);

            // Update variabel path untuk disimpan ke DB
            $imagePath = 'penyakit/' . $filename;
        }

        // 3. Update Database
        $penyakit->update([
            'kode' => $request->kode,
            'nama_penyakit' => $request->nama_penyakit,
            'gambar' => $imagePath, // Path baru atau tetap yang lama
        ]);

        // 4. Sync relasi
        $penyakit->gejalas()->sync($request->gejala_ids);
        $penyakit->solusis()->sync($request->solusi_ids);

        // 5. Hitung ulang
        if (method_exists($this, 'recalculatePc')) {
            $this->recalculatePc();
        }

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Data penyakit berhasil diperbarui.');
    }

    /**
     * BARU: Menghapus Penyakit
     */
    public function destroy(string $id)
    {
        $penyakit = Penyakit::findOrFail($id);

        // Relasi di tabel pivot (gejala_penyakit, penyakit_solusi)
        // akan otomatis terhapus karena kita set 'onDelete('cascade')' di migrasi.
        $penyakit->delete();

        // Hitung ulang SEMUA nilai P(c)
        $this->recalculatePc();

        return redirect()->route('admin.aturan.index')->with('success', 'Penyakit berhasil dihapus dan P(c) telah dihitung ulang.');
    }


    /**
     * BARU: Logika untuk menghitung ulang P(c)
     * Ini berdasarkan logika tabel Anda: P(c) = (Jumlah Aturan Penyakit C) / (Total Semua Aturan)
     */
    private function recalculatePc()
    {
        // 1. Dapatkan total jumlah relasi (Total Muncul = 49 di data lama Anda)
        $totalMuncul = DB::table('gejala_penyakit')->count();

        if ($totalMuncul == 0) return; // Hindari pembagian dengan nol

        // 2. Dapatkan semua penyakit dengan jumlah gejala (aturan)
        $penyakits = Penyakit::withCount('gejalas')->get();

        // 3. Loop dan update P(c) untuk setiap penyakit
        foreach ($penyakits as $penyakit) {
            $pc = $penyakit->gejalas_count / $totalMuncul;
            $penyakit->p_c = $pc;
            $penyakit->saveQuietly(); // Simpan tanpa memicu event lain
        }

        // Catatan: Nilai 'm' (total gejala unik) untuk Naive Bayes
        // juga harus diperbarui di DiagnosaController.
        // Sebaiknya nilai 'm' diambil dari 'Gejala::count()'
    }

    /**
     * BARU: Logika untuk menambah gejala baru via AJAX
     */
    public function storeGejalaAjax(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:gejalas',
            'gejala' => 'required|string|max:255',
        ], [
            // Validasi Kode
            'kode.required' => 'Kode gejala wajib diisi.',
            'kode.string'   => 'Kode gejala harus berupa teks.',
            'kode.max'      => 'Kode gejala maksimal 10 karakter.',
            'kode.unique'   => 'Kode gejala ini sudah terdaftar, silakan gunakan kode lain.',

            // Validasi Nama Gejala
            'gejala.required' => 'Nama gejala wajib diisi.',
            'gejala.string'   => 'Nama gejala harus berupa teks.',
            'gejala.max'      => 'Nama gejala maksimal 255 karakter.',
        ]);

        $gejala = Gejala::create($request->all());

        // Kirim kembali data gejala baru sebagai JSON
        return response()->json([
            'success' => true,
            'message' => 'Gejala baru berhasil ditambahkan!',
            'gejala' => [
                'id' => $gejala->id,
                'kode' => $gejala->kode,
                'gejala' => $gejala->gejala
            ]
        ]);
    }

    public function storeSolusiAjax(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'kode'      => 'required|unique:solusis,kode|max:10',
            'nama_obat' => 'required|string|max:255',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Validasi Kode
            'kode.required' => 'Kode obat wajib diisi.',
            'kode.unique'   => 'Kode obat ini sudah terdaftar, silakan gunakan kode lain.',
            'kode.max'      => 'Kode obat maksimal 10 karakter.',

            // Validasi Nama Obat
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'nama_obat.string'   => 'Nama obat harus berupa teks.',
            'nama_obat.max'      => 'Nama obat maksimal 255 karakter.',

            // Validasi Gambar
            'gambar.required' => 'Gambar obat wajib di isi',
            'gambar.image' => 'File yang diupload harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar.max'   => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $dbPath = null;

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                // Buat nama file unik
                $filename = time() . '_' . $file->getClientOriginalName();

                // Pindahkan file ke folder: public/obat
                $file->move(public_path('obat'), $filename);

                // Path yang disimpan di database: obat/namafile.jpg
                $dbPath = 'obat/' . $filename;
            }

            // 2. Simpan ke DB
            $solusi = Solusi::create([
                'kode'        => $request->kode,
                'nama_obat'   => $request->nama_obat,
                // PERBAIKAN DISINI: Gunakan $dbPath langsung, jangan $Path
                'gambar_obat' => $dbPath,
            ]);

            // PERBAIKAN DISINI: Hapus 'storage/' karena file ada di public/obat
            $imageUrl = $solusi->gambar_obat ? asset($solusi->gambar_obat) : null;

            return response()->json([
                'success'   => true,
                'message'   => 'Solusi/Obat berhasil ditambahkan!',
                'solusi'    => $solusi,
                'image_url' => $imageUrl
            ]);
        } catch (\Exception $e) {
            // Log error
            \Log::error('Gagal simpan solusi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
