<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrean_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrean_id')->constrained('antreans')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['antrean_id', 'layanan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrean_layanan');
    }
};
