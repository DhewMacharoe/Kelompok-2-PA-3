<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua data layanan sebelumnya
        DB::table('layanans')->truncate();
        
        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $layanans = [
            [
                'id' => 11,
                'nama' => 'Regular',
                'harga' => 60000,
                'estimasi_waktu' => '60',
                'deskripsi' => 'Haircut, hairwash, styling',
                'ikon' => 'scissors',
                'is_active' => true,
                'created_at' => '2026-06-11 07:45:44',
                'updated_at' => '2026-06-11 07:45:44',
                'user_id' => null,
            ],
            [
                'id' => 12,
                'nama' => 'Premium',
                'harga' => 80000,
                'estimasi_waktu' => '90',
                'deskripsi' => 'Haircut, hairwash, tonic, hot towel, head massage, cold towe',
                'ikon' => 'scissors',
                'is_active' => true,
                'created_at' => '2026-06-11 07:48:21',
                'updated_at' => '2026-06-11 07:48:21',
                'user_id' => null,
            ],
            [
                'id' => 13,
                'nama' => 'Executive',
                'harga' => 100000,
                'estimasi_waktu' => '120',
                'deskripsi' => 'Haircut, hairwash, black mask, tonic, hot towel, head massag',
                'ikon' => 'scissors',
                'is_active' => true,
                'created_at' => '2026-06-11 07:49:48',
                'updated_at' => '2026-06-11 07:49:48',
                'user_id' => null,
            ],
            [
                'id' => 14,
                'nama' => 'Bald',
                'harga' => 60000,
                'estimasi_waktu' => '45',
                'deskripsi' => 'Complete head shave using clippers or razor for a smooth fin',
                'ikon' => 'scissors',
                'is_active' => true,
                'created_at' => '2026-06-11 07:52:21',
                'updated_at' => '2026-06-11 07:56:36',
                'user_id' => null,
            ],
            [
                'id' => 15,
                'nama' => 'Shaving',
                'harga' => 30000,
                'estimasi_waktu' => '20',
                'deskripsi' => 'Clean facial shave or precision beard trim.',
                'ikon' => 'face',
                'is_active' => true,
                'created_at' => '2026-06-11 07:52:45',
                'updated_at' => '2026-06-11 07:56:20',
                'user_id' => null,
            ],
            [
                'id' => 16,
                'nama' => 'Face Facial',
                'harga' => 30000,
                'estimasi_waktu' => '30',
                'deskripsi' => 'Refreshing facial treatment, head massage, and cold towel.',
                'ikon' => 'face',
                'is_active' => true,
                'created_at' => '2026-06-11 07:53:24',
                'updated_at' => '2026-06-11 07:58:43',
                'user_id' => null,
            ],
            [
                'id' => 17,
                'nama' => 'Coloring Basic / Fashion',
                'harga' => 100000,
                'estimasi_waktu' => '60',
                'deskripsi' => 'Professional hair coloring using natural or trendy fashion s',
                'ikon' => 'paint',
                'is_active' => true,
                'created_at' => '2026-06-11 07:55:59',
                'updated_at' => '2026-06-11 07:55:59',
                'user_id' => null,
            ],
            [
                'id' => 18,
                'nama' => 'Hairwash & Style',
                'harga' => 30000,
                'estimasi_waktu' => '20',
                'deskripsi' => 'Invigorating hair wash followed by professional styling.',
                'ikon' => 'scissors',
                'is_active' => true,
                'created_at' => '2026-06-11 07:57:58',
                'updated_at' => '2026-06-11 07:57:58',
                'user_id' => null,
            ],
            [
                'id' => 19,
                'nama' => 'Bleaching',
                'harga' => 200000,
                'estimasi_waktu' => '90',
                'deskripsi' => 'Professional hair lightening process to prepare for vivid co',
                'ikon' => 'paint',
                'is_active' => true,
                'created_at' => '2026-06-11 07:58:27',
                'updated_at' => '2026-06-15 08:51:30',
                'user_id' => null,
            ],
        ];

        foreach ([1, 2, 3] as $barbershopId) {
            foreach ($layanans as $layanan) {
                $layananCopy = $layanan;
                unset($layananCopy['id']);
                $layananCopy['barbershop_id'] = $barbershopId;
                DB::table('layanans')->insert($layananCopy);
            }
        }
    }
}
