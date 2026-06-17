<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->boolean('is_booking')->default(false)->after('status');
            $table->date('tanggal_booking')->nullable()->after('is_booking');
            $table->time('waktu_booking')->nullable()->after('tanggal_booking');
        });
    }

    public function down()
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn(['is_booking', 'tanggal_booking', 'waktu_booking']);
        });
    }
};
