<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = App\Models\User::role('admin')->first();
app()->instance('currentTenantId', $admin->barbershop_id);
$users = App\Models\User::role('user')->whereHas('antreans')->pluck('email');
dump($users);
