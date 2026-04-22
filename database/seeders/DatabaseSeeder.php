<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrian;
use App\Models\User; // Tambahkan ini untuk memanggil model User

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Data Akun Admin (Ini yang tadi hilang)

        // 4. Data Antrian
        $antrians = [
            ['nomor_antrian' => '05', 'nama_pelanggan' => 'Budi Santoso', 'status' => 'sedang dilayani', 'waktu_masuk' => now()->subMinutes(30)],
            ['nomor_antrian' => '06', 'nama_pelanggan' => 'Andi Wijaya', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(15)],
            ['nomor_antrian' => '07', 'nama_pelanggan' => 'Deni Pratama', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(5)],
        ];
        foreach ($antrians as $antrian) {
            Antrian::create($antrian);
        }
    }
}
