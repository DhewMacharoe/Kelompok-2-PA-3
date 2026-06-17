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
            'nama_brand' => "Arga Home's",
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
