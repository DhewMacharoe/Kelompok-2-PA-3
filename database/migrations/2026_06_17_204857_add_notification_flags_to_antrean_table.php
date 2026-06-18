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
        Schema::table('antreans', function (Blueprint $table) {
            $table->boolean('is_notified_near')->default(false)->after('status');
            $table->boolean('is_notified_time')->default(false)->after('is_notified_near');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn(['is_notified_near', 'is_notified_time']);
        });
    }
};
