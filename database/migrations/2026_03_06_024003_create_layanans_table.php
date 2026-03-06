<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['Layanan Rambut', 'Layanan Jenggot', 'Perawatan']);
            $table->integer('harga');
            $table->string('estimasi_waktu')->nullable(); // misal: "30 menit"
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // path gambar
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
    protected $guarded = [];
};
