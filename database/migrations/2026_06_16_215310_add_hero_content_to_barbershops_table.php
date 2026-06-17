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
        Schema::table('barbershops', function (Blueprint $table) {
            $table->text('deskripsi_hero')->default('Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!')->after('slogan');
            $table->string('gambar_hero')->nullable()->after('deskripsi_hero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barbershops', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_hero', 'gambar_hero']);
        });
    }
};
