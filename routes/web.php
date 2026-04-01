<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute untuk antarmuka publik dan admin aplikasi antrian barbershop.
|
*/

// ==========================================
// RUTE PUBLIK (SISI PELANGGAN)
// ==========================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/layanan', [PublicController::class, 'layanan'])->name('layanan');
Route::get('/antrian', [PublicController::class, 'antrian'])->name('antrian');
Route::get('/rekomendasi', [PublicController::class, 'rekomendasi'])->name('rekomendasi');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/menu', [PublicController::class, 'menu'])->name('menu');

// ==========================================
// RUTE OTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTE ADMIN 
// ==========================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard Utama Admin
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // --- RUTE AKSI ANTRIAN (DIPINDAHKAN KE SINI) ---
    Route::post('/antrian/{id}/panggil', [App\Http\Controllers\AdminController::class, 'panggil'])->name('antrian.panggil');
    Route::post('/antrian/{id}/selesai', [App\Http\Controllers\AdminController::class, 'selesai'])->name('antrian.selesai');
    Route::post('/antrian/{id}/batal', [App\Http\Controllers\AdminController::class, 'batal'])->name('antrian.batal');

    // Kelola Antrian
    Route::get('/antrian', [App\Http\Controllers\AdminController::class, 'antrian'])->name('antrian');

    Route::get('/tambah-pelanggan', [App\Http\Controllers\AdminController::class, 'tambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/tambah-pelanggan', [App\Http\Controllers\AdminController::class, 'simpanPelanggan'])->name('simpan-pelanggan');

    // Kelola Layanan
    Route::view('/layanan', 'admin.layanan')->name('layanan');
    Route::view('/tambah-layanan', 'admin.tambah-layanan')->name('tambah-layanan');

    // Kelola Galeri (Gaya Rambut)
    Route::view('/galeri', 'admin.galeri')->name('galeri');
    Route::view('/tambah-gaya', 'admin.tambah-gaya')->name('tambah-gaya');

    // Kelola Menu Kafe
    Route::view('/menu', 'admin.menu')->name('menu');
    Route::view('/tambah-menu', 'admin.tambah-menu')->name('tambah-menu');

    // Rekap Laporan
    Route::view('/rekap', 'admin.rekap')->name('rekap');
});

// ==========================================
// REDIRECT /dashboard KE /admin/dashboard
// ==========================================
Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
});
