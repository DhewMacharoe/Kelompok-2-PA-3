<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('ikon', 20)->default('scissors')->after('deskripsi');
        });

        // Auto-mapping data lama ke sistem ikon baru:
        // Gunting (scissors) -> default (potong rambut, trimming, styling, hairwash & style, dll.)
        // Cat (paint) -> pewarnaan, coloring, bleaching, cat
        // Face (face) -> facial, perawatan wajah, skincare, mask

        DB::table('layanans')
            ->where('nama', 'like', '%facial%')
            ->orWhere('nama', 'like', '%wajah%')
            ->orWhere('nama', 'like', '%face%')
            ->orWhere('deskripsi', 'like', '%facial%')
            ->orWhere('deskripsi', 'like', '%wajah%')
            ->orWhere('deskripsi', 'like', '%skincare%')
            ->update(['ikon' => 'face']);

        DB::table('layanans')
            ->where('nama', 'like', '%color%')
            ->orWhere('nama', 'like', '%warna%')
            ->orWhere('nama', 'like', '%cat%')
            ->orWhere('nama', 'like', '%bleach%')
            ->orWhere('deskripsi', 'like', '%color%')
            ->orWhere('deskripsi', 'like', '%warna%')
            ->orWhere('deskripsi', 'like', '%cat%')
            ->orWhere('deskripsi', 'like', '%bleach%')
            ->update(['ikon' => 'paint']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('ikon');
        });
    }
};
