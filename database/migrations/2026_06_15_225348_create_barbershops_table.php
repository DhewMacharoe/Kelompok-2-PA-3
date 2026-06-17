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
            // Tenant info
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo', 255)->nullable();

            // Design info
            $table->boolean('is_active')->default(false);
            $table->string('nama_brand')->nullable();
            $table->string('favicon')->nullable();
            $table->string('alaamat')->nullable();
            $table->json('kontak')->nullable();
            $table->string('email')->nullable();
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
