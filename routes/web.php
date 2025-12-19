<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\PakarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PakarUserController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\GejalaController;

Route::get('/', function () {
    return view('welcome');
});

// Grup untuk route yang hanya bisa diakses oleh tamu (belum login)

// Route untuk menampilkan halaman login
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Untuk menampilkan halaman (GET)
Route::get('/login', [LoginController::class, 'index'])->name('login');

// DITAMBAHKAN: Untuk memproses data yang dikirim dari form (POST)
Route::post('/login', [LoginController::class, 'authenticate']);

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 2. Tambahkan route untuk registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/notifications/fetch', [ChatController::class, 'fetchNotifications'])
    ->name('notifications.fetch');

Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::get('/petani/dashboard', function () {
    return view('petani.dashboard');
})->name('petani.dashboard');
Route::get('/pakar/dashboard', function () {
    return view('pakar.dashboard');
})->name('pakar.dashboard');
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

//  Route API untuk mengambil data notifikasi


// Route untuk Pakar: Menampilkan halaman "Kotak Masuk" konsultasi
Route::get('/pakar/konsultasi', [ChatController::class, 'indexForPakar'])->name('pakar.chat.index');

// Route untuk Petani: Memulai percakapan baru dari sidebar
Route::get('/mulai-chat', [ChatController::class, 'startOrShowConversation'])->name('petani.chat.start');
Route::get('/mulai-chat/{pakar}', [ChatController::class, 'createConversation'])->name('chat.create');

// Route untuk Ruang Obrolan (digunakan bersama oleh Pakar dan Petani)
Route::get('/konsultasi/{conversation}', [ChatController::class, 'show'])->name('chat.show');

// Route untuk mengirim/menyimpan pesan baru
Route::post('/konsultasi/{conversation}', [ChatController::class, 'store'])->name('chat.store');

// route profile petani
// Route untuk MENAMPILKAN halaman edit profil
Route::get('/profile', [PetaniController::class, 'edit'])->name('profile.edit');

// Route untuk MENYIMPAN perubahan dari form (menggunakan method PUT)
Route::put('/profile', [PetaniController::class, 'update'])->name('profile.update');

Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('petani.diagnosa.index');
Route::post('/diagnosa/hitung', [DiagnosaController::class, 'calculate'])->name('diagnosa.calculate');
Route::post('/aturan/solusi-ajax', [AturanController::class, 'storeSolusiAjax'])
    ->name('admin.aturan.storeSolusiAjax');


// Rute Profil Pakar
Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::get('/profile', [PakarController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PakarController::class, 'update'])->name('profile.update');
    // Route untuk melihat daftar pengguna
    Route::get('/users', [PakarUserController::class, 'index'])->name('users.index');
    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/diagnosa/hitung', [DiagnosaController::class, 'calculate'])->name('diagnosa.calculate');
    Route::get('/gejala', [GejalaController::class, 'index'])->name('gejala.index');
});

// Rute Profil Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [AdminController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminController::class, 'update'])->name('profile.update');
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/diagnosa/hitung', [DiagnosaController::class, 'calculate'])->name('diagnosa.calculate');
    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/diagnosa/hitung', [DiagnosaController::class, 'calculate'])->name('diagnosa.calculate');
    Route::resource('aturan', AturanController::class);
    Route::post('aturan/storeGejalaAjax', [AturanController::class, 'storeGejalaAjax'])->name('aturan.storeGejalaAjax');
    Route::post('aturan/storeSolusiAjax', [AturanController::class, 'storeSolusiAjax'])->name('aturan.storeSolusiAjax');
    Route::get('/gejala', [GejalaController::class, 'index'])->name('gejala.index');
    Route::post('/gejala/store-ajax', [GejalaController::class, 'storeAjax'])->name('gejala.store.ajax');
    
});

Route::prefix('petani')->name('petani.')->group(function () {

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');
    Route::get('/gejala', [GejalaController::class, 'index'])->name('gejala.index');
});
