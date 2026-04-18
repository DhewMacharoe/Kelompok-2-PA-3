<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\Admin\LayananController;

Route::get('/test1',[AntrianController::class, 'index'])->name('test');


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

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


