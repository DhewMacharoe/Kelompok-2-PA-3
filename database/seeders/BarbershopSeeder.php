<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarbershopSeeder extends Seeder
{
    public function run()
    {
        DB::table('barbershops')->truncate();

        DB::table('barbershops')->insert([
            'is_active' => true,
            'is_cafe_active' => true,
            'nama_brand' => "Arga Barbershop",
            'favicon' => 'assets/images/logo.png',
            'alaamat' => 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara',
            'kontak' => json_encode([
                'instagram' => 'https://instagram.com',
                'facebook' => 'https://facebook.com',
                'whatsapp' => '082167893019',
                'map_embed' => 'https://maps.google.com/maps?q=2.386130,99.147852&z=15&output=embed',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.386130,99.147852'
            ]),
            'email' => 'joebarberid@gmail.com',
            'warna_primer' => '#e8a53a',
            'slogan' => 'Barber, Coffee & Food',
            'deskripsi_hero' => 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!',
            'judul_hero_layanan' => 'Daftar Layanan',
            'deskripsi_hero_layanan' => 'Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.',
            'judul_hero_galeri' => 'Galeri Arga Barbershop',
            'deskripsi_hero_galeri' => 'Lihat suasana barbershop, hasil potongan rambut, dan area cafe sebelum datang ke tempat.',
            'judul_hero_menu' => 'Menu Café',
            'deskripsi_hero_menu' => 'Nikmati berbagai pilihan makanan dan minuman kopi yang tersedia di barbershop kami.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seeder design untuk Barbershop 2 (Toba Barbershop) - Cafe Nonaktif
        DB::table('designs')->insert([
            'barbershop_id' => 2,
            'is_active' => true,
            'is_cafe_active' => false, // Nonaktifkan Cafe
            'nama_brand' => "Toba Barbershop",
            'favicon' => 'assets/images/logo.png',
            'alaamat' => 'Jl. Sisingamangaraja No. 45, Balige',
            'kontak' => json_encode([
                'instagram' => 'https://instagram.com',
                'facebook' => 'https://facebook.com',
                'whatsapp' => '082198765432',
                'map_embed' => 'https://maps.google.com/maps?q=2.383120,99.148810&z=15&output=embed',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.383120,99.148810'
            ]),
            'email' => 'tobabarber@gmail.com',
            'warna_primer' => '#3498db', // Biru
            'slogan' => 'Premium Grooming Experience',
            'deskripsi_hero' => 'Nikmati layanan pangkas rambut kelas satu dengan pemandangan Danau Toba yang indah.',
            'judul_hero_layanan' => 'Layanan Kami',
            'deskripsi_hero_layanan' => 'Daftar perawatan rambut premium untuk penampilan maksimal Anda.',
            'judul_hero_galeri' => 'Galeri Toba Barbershop',
            'deskripsi_hero_galeri' => 'Dokumentasi visual kenyamanan dan hasil potongan rambut di Toba Barbershop.',
            'judul_hero_menu' => 'Menu Café',
            'deskripsi_hero_menu' => 'Nikmati menu café spesial kami.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seeder design untuk Barbershop 3 (Laguboti Barbershop)
        DB::table('designs')->insert([
            'barbershop_id' => 3,
            'is_active' => true,
            'is_cafe_active' => true,
            'nama_brand' => "Laguboti Barbershop",
            'favicon' => 'assets/images/logo.png',
            'alaamat' => 'Jl. Sisingamangaraja No. 102, Laguboti',
            'kontak' => json_encode([
                'instagram' => 'https://instagram.com',
                'facebook' => 'https://facebook.com',
                'whatsapp' => '082111223344',
                'map_embed' => 'https://maps.google.com/maps?q=2.378900,99.124500&z=15&output=embed',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.378900,99.124500'
            ]),
            'email' => 'lagubotibarber@gmail.com',
            'warna_primer' => '#2ecc71', // Hijau
            'slogan' => 'Gentlemen Haircut & Cafe',
            'deskripsi_hero' => 'Solusi ketampanan pria modern di Laguboti. Cepat, rapi, dan terjangkau.',
            'judul_hero_layanan' => 'Pilihan Layanan',
            'deskripsi_hero_layanan' => 'Kami menyediakan berbagai tipe potongan rambut sesuai gaya terkini.',
            'judul_hero_galeri' => 'Galeri Laguboti Barbershop',
            'deskripsi_hero_galeri' => 'Foto-foto sudut Laguboti Barbershop yang estetik dan hasil pangkas rambut pelanggan.',
            'judul_hero_menu' => 'Menu Café Kami',
            'deskripsi_hero_menu' => 'Nikmati kopi dan cemilan hangat sambil menunggu antrean Anda.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
