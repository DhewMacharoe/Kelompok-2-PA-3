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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nama', 25);
            $table->enum('kategori', ['Minuman', 'Makanan']);
            $table->mediumInteger('harga');
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('is_available')->default(true); // true = Tersedia, false = Habis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
    protected $guarded = [];
};
