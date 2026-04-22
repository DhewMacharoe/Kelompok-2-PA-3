<?php

use App\Http\Controllers\AntrianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PelangganLayananController;

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

require __DIR__ . '/admin_route.php';

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/layanan', [PelangganLayananController::class, 'index'])->name('pelanggan.layanan');
Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');
Route::get('/rekomendasi', [PublicController::class, 'rekomendasi'])->name('rekomendasi');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/menu', [PublicController::class, 'menu'])->name('menu');
Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');
Route::patch('/antrian/saya/batal', [AntrianController::class, 'cancelMyQueue'])
    ->name('antrian.cancel')
    ->middleware('auth');



// ==========================================
// RUTE OTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login-user', [AuthController::class, 'showUserLogin'])->name('login.user');
Route::post('/firebase-login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');
Route::get('/set-username', [AuthController::class, 'showSetUsername'])->name('set.username');
Route::post('/set-username', [AuthController::class, 'doSetUsername'])->name('set.username.post');

// Test Firebase connection
Route::get('/test-firebase', [AuthController::class, 'testFirebase'])->name('test.firebase');


// Rute untuk pelanggan mengambil antrian
Route::post('/antrian/daftar', [PublicController::class, 'daftarAntrian'])
    ->name('antrian.daftar')
    ->middleware('auth');
