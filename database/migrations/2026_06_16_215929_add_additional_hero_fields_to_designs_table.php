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
        Schema::table('designs', function (Blueprint $table) {
            // Layanan
            $table->string('judul_hero_layanan')->default('Daftar Layanan')->after('gambar_hero');
            $table->text('deskripsi_hero_layanan')->default('Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.')->after('judul_hero_layanan');
            $table->string('gambar_hero_layanan')->nullable()->after('deskripsi_hero_layanan');

            // Galeri
            $table->string('judul_hero_galeri')->default('Galeri Kami')->after('gambar_hero_layanan');
            $table->text('deskripsi_hero_galeri')->default('Lihat suasana barbershop, hasil potongan rambut, dan area coffee sebelum datang ke tempat.')->after('judul_hero_galeri');
            $table->string('gambar_hero_galeri')->nullable()->after('deskripsi_hero_galeri');

            // Menu Café
            $table->string('judul_hero_menu')->default('Menu Café')->after('gambar_hero_galeri');
            $table->text('deskripsi_hero_menu')->default('Nikmati berbagai pilihan makanan dan minuman kopi yang tersedia di barbershop kami.')->after('judul_hero_menu');
            $table->string('gambar_hero_menu')->nullable()->after('deskripsi_hero_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn([
                'judul_hero_layanan', 'deskripsi_hero_layanan', 'gambar_hero_layanan',
                'judul_hero_galeri', 'deskripsi_hero_galeri', 'gambar_hero_galeri',
                'judul_hero_menu', 'deskripsi_hero_menu', 'gambar_hero_menu'
            ]);
        });
    }
};
