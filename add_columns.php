<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    if (!Schema::hasColumn('antreans', 'is_booking')) {
        Schema::table('antreans', function (Blueprint $table) {
            $table->boolean('is_booking')->default(false)->after('waktu_masuk');
            $table->date('tanggal_booking')->nullable()->after('is_booking');
            $table->time('waktu_booking')->nullable()->after('tanggal_booking');
        });
        echo "Columns added successfully!\n";
    } else {
        echo "Columns already exist!\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
