<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrean;
use App\Models\User; // Tambahkan ini untuk memanggil model User

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Data Akun Admin (Ini yang tadi hilang)

        // 1. Data Layanan
        $this->call(LayananSeeder::class);

        // 2. Data Menu Kafe
        $this->call(MenuSeeder::class);

        // 4. Data Antrean
        $antreans = [
            ['nomor_antrean' => '05', 'nama_pelanggan' => 'Budi Santoso', 'status' => 'sedang dilayani', 'waktu_masuk' => now()->subMinutes(30)],
            ['nomor_antrean' => '06', 'nama_pelanggan' => 'Andi Wijaya', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(15)],
            ['nomor_antrean' => '07', 'nama_pelanggan' => 'Deni Pratama', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(5)],
        ];
        foreach ($antreans as $antrean) {
            Antrean::create($antrean);
        }
    }
}
