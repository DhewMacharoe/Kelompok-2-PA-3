<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuCafeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\GaleriController;

Route::get('/test1', [AntrianController::class, 'index'])->name('test');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- RUTE AKSI ANTRIAN ---
    // Route::post('/antrian/{id}/panggil', [AdminController::class, 'panggil'])->name('antrian.panggil');
    // Route::post('/antrian/{id}/selesai', [AdminController::class, 'selesai'])->name('antrian.selesai');
    // Route::post('/antrian/{id}/batal', [AdminController::class, 'batal'])->name('antrian.batal');

    Route::patch('/antrian/{id}/ubah-status', [AntrianController::class, 'ubahStatus'])->name('antrian.ubahStatus');

    // Kelola Antrian
    Route::get('/antrian', [AdminController::class, 'antrian'])->name('antrian');

    Route::post('/antrian/panggil', [AntrianController::class, 'panggil'])->name('antrian.panggil');

    Route::get('/tambah-pelanggan', [AdminController::class, 'tambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/tambah-pelanggan', [AdminController::class, 'simpanPelanggan'])->name('simpan-pelanggan');

    // Kelola Layanan (CRUD)
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
    Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');
    Route::patch('/layanan/{layanan}/toggle-status', [LayananController::class, 'toggleStatus'])->name('layanan.toggleStatus');
    Route::put('/layanan/{layanan}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    // Kelola Galeri
    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::patch('/galeri/{galeri}/toggle-status', [GaleriController::class, 'toggleStatus'])->name('galeri.toggleStatus');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

    // Kelola Menu Kafe
    Route::get('/menu', [MenuCafeController::class, 'index'])->name('menu.index');
    Route::post('/menu', [MenuCafeController::class, 'store'])->name('menu.store');
    Route::put('/menu/{menu}', [MenuCafeController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuCafeController::class, 'destroy'])->name('menu.destroy');

    // Rekap Laporan
    Route::get('/rekap', [AdminController::class, 'rekapPemasukan'])->name('rekap');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('test')->group(function () {

    Route::get('/dashboard', function () {
        return view("admin.test.dashboard");
    });

    Route::get('/antrian', function () {
        return "Antrian";
    });
});



// ==========================================
// REDIRECT /dashboard KE /admin/dashboard
// ==========================================
Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
});
