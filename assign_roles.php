<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::doesntHave('roles')->get();
foreach($users as $user) {
    $user->assignRole('user');
}
echo "Assigned roles to " . $users->count() . " users.\n";
