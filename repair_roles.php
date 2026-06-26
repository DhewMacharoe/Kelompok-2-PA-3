<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
foreach($users as $u) {
    if(!$u->hasRole('admin') && !$u->hasRole('super_admin') && !str_contains($u->email, 'admin')) {
        $u->assignRole('user');
    }
}
echo "Roles repaired.\n";
