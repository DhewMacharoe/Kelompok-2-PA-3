<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->foreignId('layanan_id1')->nullable()->after('layanan_id')->constrained('layanans')->nullOnDelete();
            $table->foreignId('layanan_id2')->nullable()->after('layanan_id1')->constrained('layanans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropForeign(['layanan_id1']);
            $table->dropForeign(['layanan_id2']);
            $table->dropColumn(['layanan_id1', 'layanan_id2']);
        });
    }
};
