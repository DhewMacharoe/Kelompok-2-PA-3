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
        User::create([
            'name' => 'Arga Admin',
            'email' => 'arga@gmail.com',
            'password' => bcrypt('barber123'),
        ]);

        // 1. Data Layanan
        $layanans = [
            ['nama' => 'Potong Rambut', 'kategori' => 'Layanan Rambut', 'harga' => 35000, 'estimasi_waktu' => '30 menit', 'deskripsi' => 'Potongan rapi sesuai bentuk wajah dan selera', 'is_active' => true],
            ['nama' => 'Creambath', 'kategori' => 'Layanan Rambut', 'harga' => 50000, 'estimasi_waktu' => '45 menit', 'deskripsi' => 'Perawatan rambut dengan krim khusus pilihan', 'is_active' => true],
            ['nama' => 'Hair Coloring', 'kategori' => 'Layanan Rambut', 'harga' => 120000, 'estimasi_waktu' => '60 menit', 'deskripsi' => 'Pewarnaan rambut dengan bahan premium', 'is_active' => false],
            ['nama' => 'Cukur Jenggot', 'kategori' => 'Layanan Jenggot', 'harga' => 25000, 'estimasi_waktu' => '20 menit', 'deskripsi' => 'Rapikan jenggot sesuai selera', 'is_active' => true],
            ['nama' => 'Desain Jenggot', 'kategori' => 'Layanan Jenggot', 'harga' => 35000, 'estimasi_waktu' => '30 menit', 'deskripsi' => 'Bentuk jenggot dengan desain tertentu', 'is_active' => true],
        ];
        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }

        // 2. Data Galeri Gaya Rambut
        $galeris = [
            ['nama' => 'Undercut', 'bentuk_wajah' => 'Oval, Persegi', 'is_active' => true],
            ['nama' => 'Pompadour', 'bentuk_wajah' => 'Oval, Lonjong', 'is_active' => true],
            ['nama' => 'Slick Back', 'bentuk_wajah' => 'Semua', 'is_active' => true],
            ['nama' => 'Quiff', 'bentuk_wajah' => 'Oval, Bulat', 'is_active' => false],
            ['nama' => 'Buzz Cut', 'bentuk_wajah' => 'Oval, Persegi', 'is_active' => true],
            ['nama' => 'Side Part', 'bentuk_wajah' => 'Semua', 'is_active' => true],
            ['nama' => 'French Crop', 'bentuk_wajah' => 'Bulat, Persegi', 'is_active' => true],
            ['nama' => 'Textured Crop', 'bentuk_wajah' => 'Oval, Lonjong', 'is_active' => true],
        ];
        foreach ($galeris as $gaya) {
            Galeri::create($gaya);
        }

        // 3. Data Menu Kafe
        $menus = [
            ['nama' => 'Kopi Hitam', 'kategori' => 'Minuman', 'harga' => 12000, 'deskripsi' => 'Kopi robusta lokal pilihan', 'is_available' => true],
            ['nama' => 'Es Kopi Susu', 'kategori' => 'Minuman', 'harga' => 18000, 'deskripsi' => 'Kopi susu segar dengan es batu', 'is_available' => true],
            ['nama' => 'Matcha Latte', 'kategori' => 'Minuman', 'harga' => 22000, 'deskripsi' => 'Teh hijau dengan susu steamed', 'is_available' => false],
            ['nama' => 'Teh Tarik', 'kategori' => 'Minuman', 'harga' => 14000, 'deskripsi' => 'Teh kental dengan susu, disajikan panas', 'is_available' => true],
            ['nama' => 'Roti Bakar', 'kategori' => 'Makanan Ringan', 'harga' => 15000, 'deskripsi' => 'Roti bakar dengan berbagai topping pilihan', 'is_available' => true],
            ['nama' => 'Pisang Goreng', 'kategori' => 'Makanan Ringan', 'harga' => 12000, 'deskripsi' => 'Pisang goreng crispy dengan saus coklat', 'is_available' => true],
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // 4. Data Antrian
        $antrians = [
            ['nomor_antrian' => '05', 'nama_pelanggan' => 'Budi Santoso', 'status' => 'dipanggil', 'waktu_masuk' => now()->subMinutes(30)],
            ['nomor_antrian' => '06', 'nama_pelanggan' => 'Andi Wijaya', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(15)],
            ['nomor_antrian' => '07', 'nama_pelanggan' => 'Deni Pratama', 'status' => 'menunggu', 'waktu_masuk' => now()->subMinutes(5)],
        ];
        foreach ($antrians as $antrian) {
            Antrian::create($antrian);
        }
    }
}
