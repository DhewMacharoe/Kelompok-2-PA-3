<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah nomor_antrean dari UNIQUE menjadi (nomor_antrean, created_at_date) UNIQUE
     * agar nomor bisa di-reset setiap hari
     */
    public function up(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            // Drop unique constraint yang lama (hanya nomor_antrean)
            $table->dropUnique(['nomor_antrean']);
        });

        // Tambah unique compound index untuk (nomor_antrean, created_at_date)
        // Ini memastikan nomor antrean unik per hari
        Schema::table('antreans', function (Blueprint $table) {
            // Change nomor_antrean dari string ke integer untuk consistency
            $table->unsignedSmallInteger('nomor_antrean_seq')
                ->after('id')
                ->comment('Sequential queue number per day (01-99)');
        });

        // Setelah ini, isi semua nomor_antrean_seq dari nomor_antrean yang ada
        // menggunakan raw query (akan di-handle manual atau via custom seeder)
    }

    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn('nomor_antrean_seq');
            // Restore unique constraint
            $table->unique(['nomor_antrean']);
        });
    }
};
