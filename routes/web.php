<?php

use App\Http\Controllers\Pelanggan\AntreanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Pelanggan\PelangganLayananController;
use App\Http\Controllers\Pelanggan\PelangganGaleriController;
use App\Http\Controllers\Pelanggan\PelangganRekomendasiController;
use App\Http\Controllers\Pelanggan\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute untuk antarmuka publik dan admin aplikasi antrean barbershop.
|
*/

// ==========================================
// RUTE PUBLIK (SISI PELANGGAN)
// ==========================================

require __DIR__ . '/admin_route.php';

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/layanan', [PelangganLayananController::class, 'index'])->name('pelanggan.layanan');
Route::get('/antrean', [AntreanController::class, 'index'])->name('antrean');
Route::get('/rekomendasi', [PublicController::class, 'rekomendasi'])->name('rekomendasi');
Route::get('/galeri', [PelangganGaleriController::class, 'index'])->name('galeri');
Route::get('/menu', [PublicController::class, 'menu'])->name('menu');
Route::post('/antrean', [AntreanController::class, 'store'])->name('antrean.store');
Route::patch('/antrean/saya/batal', [AntreanController::class, 'cancelMyQueue'])
    ->name('antrean.cancel')
    ->middleware('auth');

Route::get('/rekomendasi', [PelangganRekomendasiController::class, 'rekomendasi'])->name('rekomendasi.index');
Route::post('/rekomendasi/process', [PelangganRekomendasiController::class, 'process'])->name('rekomendasi.process');


// ==========================================
// RUTE OTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login-user', [AuthController::class, 'showUserLogin'])->name('login.user');
Route::post('/firebase-login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');
Route::get('/set-username', [AuthController::class, 'showSetUsername'])->name('set.username')->middleware('auth');
Route::post('/set-username', [AuthController::class, 'doSetUsername'])->name('set.username.post')->middleware('auth');

// Test Firebase connection
Route::get('/test-firebase', [AuthController::class, 'testFirebase'])->name('test.firebase');


// Rute untuk pelanggan mengambil antrean
Route::post('/antrean/daftar', [PublicController::class, 'daftarAntrean'])
    ->name('antrean.daftar')
    ->middleware('auth');

// Rute untuk profil pelanggan
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Serve image files stored in project-root /images for local/dev access.
Route::get('/images/{path}', function (string $path) {
    $baseDirectory = realpath(base_path('images'));
    $filePath = realpath(base_path('images/' . $path));

    if (
        !$baseDirectory ||
        !$filePath ||
        !str_starts_with($filePath, $baseDirectory . DIRECTORY_SEPARATOR) ||
        !is_file($filePath)
    ) {
        abort(404);
    }

    return response()->file($filePath);
})->where('path', '.*')->name('images.serve');
