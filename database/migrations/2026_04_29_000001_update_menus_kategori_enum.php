<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Perbarui nilai yang sudah ada jika menggunakan "Makanan Ringan".
        DB::table('menus')
            ->where('kategori', 'Makanan Ringan')
            ->update(['kategori' => 'Makanan']);

        DB::statement("ALTER TABLE `menus` MODIFY `kategori` ENUM('Minuman','Makanan') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `menus` MODIFY `kategori` ENUM('Minuman','Makanan Ringan') NOT NULL");
    }
};
