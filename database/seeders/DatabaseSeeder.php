<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrean;
use App\Models\User; // Tambahkan ini untuk memanggil model User
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Create Role Admin dulu
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Create User Admin
        $admin = User::create([
            'name' => 'Arga Admin',
            'email' => 'arga@gmail.com',
            'username' => 'argaadmin',
            'password' => bcrypt('barber123'),
        ]);
        $admin->assignRole('admin');

        // 1. Data Layanan
        $this->call(LayananSeeder::class);

        // 2. Data Menu Kafe
        $this->call(MenuSeeder::class);
    }
}
