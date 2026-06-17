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
        Schema::create('barbershops', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->string('nama_brand');
            $table->string('favicon');
            $table->string('alaamat');
            $table->json('kontak');
            $table->string('email');
            $table->string('warna_primer', 7)->default('#e8a53a');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barbershops');
    }
};
