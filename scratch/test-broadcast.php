<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$antrean = \App\Models\Antrean::first();
if (!$antrean) {
    echo "No antrean found in database!\n";
    exit(1);
}

echo "Dispatching AntreanUpdate for customer: " . $antrean->nama_pelanggan . "\n";
event(new \App\Events\AntreanUpdate($antrean));
echo "Successfully dispatched AntreanUpdate!\n";

$antreanList = \App\Models\Antrean::getTodayWaitingQueues();
echo "Dispatching AntreanListUpdate with " . count($antreanList) . " items\n";
event(new \App\Events\AntreanListUpdate($antreanList));
echo "Successfully dispatched AntreanListUpdate!\n";
