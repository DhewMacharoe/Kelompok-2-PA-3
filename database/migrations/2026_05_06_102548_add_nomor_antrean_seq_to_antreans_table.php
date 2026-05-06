<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Refactor nomor_antrean: add nomor_antrean_seq, copy data, drop old column
     */
    public function up(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            // Tambah kolom nomor_antrean_seq sebagai nullable dulu
            $table->unsignedSmallInteger('nomor_antrean_seq')
                ->nullable()
                ->after('id')
                ->comment('Sequential queue number per day (01-99)');
        });

        // Copy data dari nomor_antrean ke nomor_antrean_seq
        DB::statement('UPDATE antreans SET nomor_antrean_seq = CAST(nomor_antrean AS UNSIGNED)');

        // Set kolom menjadi NOT NULL setelah data ter-copy
        Schema::table('antreans', function (Blueprint $table) {
            $table->unsignedSmallInteger('nomor_antrean_seq')
                ->nullable(false)
                ->change();
        });

        // Drop kolom nomor_antrean lama
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn('nomor_antrean');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->string('nomor_antrean')->unique()->after('id');
        });

        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn('nomor_antrean_seq');
        });
    }
};

