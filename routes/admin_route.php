<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- RUTE AKSI ANTRIAN (DIPINDAHKAN KE SINI) ---
    Route::post('/antrian/{id}/panggil', [AdminController::class, 'panggil'])->name('antrian.panggil');
    Route::post('/antrian/{id}/selesai', [AdminController::class, 'selesai'])->name('antrian.selesai');
    Route::post('/antrian/{id}/batal', [AdminController::class, 'batal'])->name('antrian.batal');

    // Kelola Antrian
    Route::get('/antrian', [AdminController::class, 'antrian'])->name('antrian');

    Route::get('/tambah-pelanggan', [AdminController::class, 'tambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/tambah-pelanggan', [AdminController::class, 'simpanPelanggan'])->name('simpan-pelanggan');

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


