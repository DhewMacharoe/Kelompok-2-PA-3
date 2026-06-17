<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel barber_shops
        Schema::create('barber_shops', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo', 255)->nullable();
            $table->timestamps();
        });

        // 2. Masukkan tenant/barbershop default agar tidak ada data orphan
        DB::table('barber_shops')->insert([
            'id' => 1,
            'nama' => 'Arga Barbershop',
            'slug' => 'arga-barbershop',
            'alamat' => 'Jl. Raya Toba No. 12, Balige',
            'telepon' => '081234567890',
            'deskripsi' => 'Barbershop terbaik di Balige dengan pelayanan ramah dan profesional.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Tambahkan barbershop_id ke tabel users (nullable karena pelanggan bersifat global, super admin juga global)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('barbershop_id')->nullable()->after('id')->constrained('barber_shops')->onDelete('set null');
        });

        // Update admin default yang ada agar terasosiasi ke Arga Barbershop
        DB::table('users')->where('email', 'arga@gmail.com')->update(['barbershop_id' => 1]);

        // 4. Tambahkan barbershop_id ke tabel operasional (antreans, layanans, menus, galeris, settings, designs)
        $tables = ['antreans', 'layanans', 'menus', 'galeris', 'settings', 'designs'];

        foreach ($tables as $tableName) {
            // Tambah kolom sebagai nullable terlebih dahulu
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('barbershop_id')->nullable()->after('id');
            });

            // Migrasikan data lama ke tenant default (ID = 1)
            DB::table($tableName)->update(['barbershop_id' => 1]);

            // Ubah kolom menjadi NOT NULL dan buat foreign key constraint
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->unsignedBigInteger('barbershop_id')->nullable(false)->change();
                $table->foreign('barbershop_id')->references('id')->on('barber_shops')->onDelete('cascade');
            });
        }

        // 5. Sesuaikan index unik pada tabel settings
        Schema::table('settings', function (Blueprint $table) {
            // Drop index unique key yang lama (settings_key_unique)
            $table->dropUnique('settings_key_unique');
            
            // Tambahkan composite unique index baru
            $table->unique(['barbershop_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Kembalikan index unik pada settings
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique(['barbershop_id', 'key']);
            $table->unique('key');
        });

        // 2. Hapus foreign key dan kolom barbershop_id dari tabel operasional
        $tables = ['settings', 'galeris', 'menus', 'layanans', 'antreans', 'designs'];
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropForeign([$tableName . '_barbershop_id_foreign']);
                $table->dropColumn('barbershop_id');
            });
        }

        // 3. Hapus foreign key dan kolom barbershop_id dari users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['users_barbershop_id_foreign']);
            $table->dropColumn('barbershop_id');
        });

        // 4. Hapus tabel barber_shops
        Schema::dropIfExists('barber_shops');
    }
};
