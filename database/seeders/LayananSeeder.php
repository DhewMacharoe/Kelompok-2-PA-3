<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua data layanan sebelumnya
        Layanan::truncate();
        
        // Aktifkan kembali foreign key check
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $layanans = [
            [
                'nama' => 'Punxgoaran Silver Cut',
                'harga' => 50000,
                'estimasi_waktu' => '30',
                'deskripsi' => 'Potong rambut standar dengan menggunakan gunting profesional. Cocok untuk pemeliharaan rambut regular dan rapi dengan hasil yang sempurna.',
                'is_active' => true,
            ],
            [
                'nama' => 'Punxgoaran Gold Cut',
                'harga' => 70000,
                'estimasi_waktu' => '45',
                'deskripsi' => 'Potong rambut premium dengan konsultasi gaya rambut gratis. Termasuk styling dan finishing khusus dengan produk premium untuk hasil maksimal.',
                'is_active' => true,
            ],
            [
                'nama' => 'Punxgoaran Diamond Cut',
                'harga' => 100000,
                'estimasi_waktu' => '60',
                'deskripsi' => 'Potong rambut eksklusif VIP dengan barber berpengalaman tinggi. Termasuk konsultasi mendalam, styling custom, beard grooming, dan perawatan khusus.',
                'is_active' => true,
            ],
            [
                'nama' => 'Punxgoaran Kids Cut',
                'harga' => 30000,
                'estimasi_waktu' => '25',
                'deskripsi' => 'Layanan potong rambut khusus untuk anak-anak dengan barber yang sabar dan berpengalaman. Lingkungan yang nyaman dan menyenangkan untuk si kecil.',
                'is_active' => true,
            ],
            [
                'nama' => 'Shaving',
                'harga' => 25000,
                'estimasi_waktu' => '20',
                'deskripsi' => 'Layanan cukur kumis dan jenggot dengan teknik tradisional atau modern sesuai keinginan. Menggunakan pisau cukur berkualitas dan produk perawatan terbaik.',
                'is_active' => true,
            ],
            [
                'nama' => 'Face Facial',
                'harga' => 25000,
                'estimasi_waktu' => '30',
                'deskripsi' => 'Perawatan wajah profesional dengan membersihkan pori-pori dan menutrisi kulit. Menggunakan produk skincare berkualitas untuk kulit yang lebih sehat dan bercahaya.',
                'is_active' => true,
            ],
            [
                'nama' => 'Hairwash & Style',
                'harga' => 20000,
                'estimasi_waktu' => '25',
                'deskripsi' => 'Layanan cuci rambut dengan massage kepala relaksasi dan styling sesuai keinginan. Menggunakan shampoo dan produk perawatan rambut premium untuk hasil terbaik.',
                'is_active' => true,
            ],
            [
                'nama' => 'Coloring Basic Colour',
                'harga' => 100000,
                'estimasi_waktu' => '90',
                'deskripsi' => 'Pewarna rambut profesional dengan pilihan warna dasar. Termasuk konsultasi warna, treatment perawatan rambut, dan hasil yang tahan lama.',
                'is_active' => true,
            ],
            [
                'nama' => 'Coloring (Bawa cat sendiri)',
                'harga' => 60000,
                'estimasi_waktu' => '80',
                'deskripsi' => 'Layanan pewarna rambut dengan menggunakan produk pewarna yang Anda bawa sendiri. Barber kami siap membantu aplikasi dengan teknik profesional dan teliti.',
                'is_active' => true,
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
