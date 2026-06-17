<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antreans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->unsignedSmallInteger('nomor_antrean_seq')->comment('Sequential queue number per day (01-99)');
            $table->string('nama_pelanggan', 25)->index();

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
            $table->boolean('is_booking')->default(false);
            $table->date('tanggal_booking')->nullable();
            $table->time('waktu_booking')->nullable();
            $table->text('alasan_batal')->nullable();
            $table->timestamp('waktu_masuk')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
            
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antreans');
    }
};
