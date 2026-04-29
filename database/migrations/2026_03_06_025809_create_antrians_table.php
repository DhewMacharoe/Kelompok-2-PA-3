<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian')->unique();
            $table->string('nama_pelanggan')->index();
            
            // Layanan yang diambil pelanggan
            $table->foreignId('layanan_id1')
                ->nullable()
                ->constrained('layanans')
                ->nullOnDelete();
            $table->foreignId('layanan_id2')
                ->nullable()
                ->constrained('layanans')
                ->nullOnDelete();
            
            // Status tracking
            $table->enum('status', ['menunggu', 'sedang dilayani', 'selesai', 'batal'])
                ->default('menunggu')
                ->index();
            $table->timestamp('waktu_masuk')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
