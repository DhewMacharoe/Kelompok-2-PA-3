<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;

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

require __DIR__.'/admin_route.php';

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/test',[HomePageController::class, 'index'])->name('test');
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

Route::get('/login-user', [AuthController::class, 'showUserLogin'])->name('login.user');
Route::post('/firebase-login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');
Route::get('/set-username', [AuthController::class, 'showSetUsername'])->name('set.username');
Route::post('/set-username', [AuthController::class, 'doSetUsername'])->name('set.username.post');

// Test Firebase connection
Route::get('/test-firebase', [AuthController::class, 'testFirebase'])->name('test.firebase');

