<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian');
            $table->string('nama_pelanggan');
            $table->foreignId('layanan_id')->nullable()->constrained('layanans')->onDelete('set null');
            $table->enum('status', ['menunggu', 'sedang dilayani', 'selesai', 'batal'])->default('menunggu');
            $table->timestamp('waktu_masuk')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('antrians');
    }
};
