<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::where('role', 'pelanggan')->first();
if(!$user) $user = \App\Models\User::first();
Auth::login($user);

$riwayatAntrean = \App\Models\Antrean::withoutGlobalScopes()
    ->with(['layanan1', 'layanan2', 'barbershop'])
    ->where('nama_pelanggan', $user->username)
    ->whereIn('status', ['selesai', 'batal'])
    ->orderBy('created_at', 'desc')
    ->get();

$bookingAktif = \App\Models\Antrean::withoutGlobalScopes()
    ->with(['layanan1', 'layanan2', 'barbershop'])
    ->where('nama_pelanggan', $user->username)
    ->where('is_booking', true)
    ->whereIn('status', ['menunggu', 'sedang dilayani'])
    ->orderBy('tanggal_booking', 'asc')
    ->orderBy('waktu_booking', 'asc')
    ->get();

$activeBarbershop = new \App\Models\Barbershop();
$activeBarbershop->nama_brand = 'Arga Barbershop';
$activeBarbershop->warna_primer = '#d4af37';
$activeDesign = $activeBarbershop;

try {
    view('pelanggan.profile.index', compact('user', 'riwayatAntrean', 'bookingAktif', 'activeBarbershop', 'activeDesign'))->render();
    echo 'OK';
} catch (\Exception $e) {
    echo $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine();
}
