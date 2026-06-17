<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuCafeController;
use App\Http\Controllers\Admin\AntreanController;
use App\Http\Controllers\Admin\BarbershopController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Kelola Antrean
    Route::get('/antrean', [AntreanController::class, 'index'])->name('antrean');
    Route::post('/antrean/panggil', [AntreanController::class, 'panggil'])->name('antrean.panggil');
    Route::patch('/antrean/{id}/ubah-status', [AntreanController::class, 'ubahStatus'])->name('antrean.ubahStatus');
    Route::patch('/antrean/batal-masal', [AntreanController::class, 'batalMasal'])->name('antrean.batalMasal');

    // Tambah Pelanggan Manual
    Route::get('/tambah-pelanggan', [AntreanController::class, 'tambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/tambah-pelanggan', [AntreanController::class, 'simpanPelanggan'])->name('simpan-pelanggan');

    // Kelola Lokasi Antrean (Settings)
    Route::get('/lokasi', [SettingController::class, 'lokasi'])->name('lokasi.index');
    Route::post('/lokasi', [SettingController::class, 'simpanLokasi'])->name('lokasi.store');

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
    Route::get('/rekap', [RekapController::class, 'rekapPemasukan'])->name('rekap');

    //barbershop
    Route::resource('barbershop', BarbershopController::class);
    Route::post('/barbershop/activate', [BarbershopController::class, 'activateBarbershop'])->name('barbershop.activate');
    Route::post('/barbershop/deactivate', [BarbershopController::class, 'deactivateBarbershop'])->name('barbershop.deactivate');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// REDIRECT /dashboard KE /admin/dashboard
// ==========================================
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->hasRole('super_admin')) {
        return redirect('/super-admin/dashboard');
    }
    return redirect('/admin/dashboard');
});

// ==========================================
// RUTE SUPER ADMIN
// ==========================================
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/switch-tenant/{id}', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'switchTenant'])->name('switch-tenant');
    
    Route::resource('barbershops', \App\Http\Controllers\SuperAdmin\BarbershopController::class);
    Route::resource('admins', \App\Http\Controllers\SuperAdmin\AdminUserController::class);
});
