<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $user = \App\Models\User::first();
    Auth::login($user);
    $html = app()->make(\App\Http\Controllers\Pelanggan\ProfileController::class)->index()->render();
    echo 'SUCCESS';
} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine();
}
