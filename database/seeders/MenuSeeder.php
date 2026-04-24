<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Hapus data menu lama agar sinkron dengan data saat ini.
        Menu::query()->delete();

        $menus = [
            [
                'nama' => 'Espresso',
                'kategori' => 'Minuman',
                'harga' => 12000,
                'deskripsi' => 'Kopi hitam pekat tanpa tambahan.',
                'foto' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?q=80&w=1200&auto=format&fit=crop',
                'is_available' => true,
            ],
            [
                'nama' => 'Americano',
                'kategori' => 'Minuman',
                'harga' => 15000,
                'deskripsi' => 'Espresso yang dicampur air panas.',
                'foto' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200&auto=format&fit=crop',
                'is_available' => true,
            ],
            [
                'nama' => 'Cappuccino',
                'kategori' => 'Minuman',
                'harga' => 20000,
                'deskripsi' => 'Espresso, susu, dan busa susu.',
                'foto' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?q=80&w=1200&auto=format&fit=crop',
                'is_available' => true,
            ],
            [
                'nama' => 'Cafe Latte',
                'kategori' => 'Minuman',
                'harga' => 22000,
                'deskripsi' => 'Espresso dan susu yang creamy.',
                'foto' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=1200&auto=format&fit=crop',
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
