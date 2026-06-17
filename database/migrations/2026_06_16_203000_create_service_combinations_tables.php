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
        Schema::create('package_service', function (Blueprint $table) {
            $table->foreignId('package_id')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('layanans')->onDelete('cascade');
            $table->primary(['package_id', 'service_id']);
        });

        Schema::create('incompatibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id_a')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('service_id_b')->constrained('layanans')->onDelete('cascade');
            $table->string('deskripsi_konflik');
            $table->unique(['service_id_a', 'service_id_b']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incompatibilities');
        Schema::dropIfExists('package_service');
    }
};
