<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barber_shops', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('logo');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->boolean('is_active')->default(true)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barber_shops', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'is_active']);
        });
    }
};
