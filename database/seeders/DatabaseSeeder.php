<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Create Roles
        if (!Role::where('name', 'super_admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
        }

        // Create or update first barbershop with coordinates
        DB::table('barber_shops')->where('id', 1)->update([
            'latitude' => 2.386130,
            'longitude' => 99.147852,
            'is_active' => true,
        ]);

        // Create second barbershop if not exists
        if (!DB::table('barber_shops')->where('id', 2)->exists()) {
            DB::table('barber_shops')->insert([
                'id' => 2,
                'nama' => 'Toba Barbershop',
                'slug' => 'toba-barbershop',
                'alamat' => 'Jl. Sisingamangaraja No. 45, Balige',
                'telepon' => '082198765432',
                'deskripsi' => 'Barbershop premium dengan pemandangan Danau Toba.',
                'latitude' => 2.383120,
                'longitude' => 99.148810,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('barber_shops')->where('id', 2)->update([
                'latitude' => 2.383120,
                'longitude' => 99.148810,
                'is_active' => true,
            ]);
        }

        // Create Super Admin if not exists
        if (!User::where('email', 'superadmin@gmail.com')->exists()) {
            $superAdmin = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'username' => 'superadmin',
                'password' => bcrypt('super123'),
                'barbershop_id' => null,
            ]);
            $superAdmin->assignRole('super_admin');
        }

        // Create User Admin (Arga Barbershop) if not exists
        if (!User::where('email', 'arga@gmail.com')->exists()) {
            $admin = User::create([
                'name' => 'Arga Admin',
                'email' => 'arga@gmail.com',
                'username' => 'argaadmin',
                'password' => bcrypt('barber123'),
                'barbershop_id' => 1,
            ]);
            $admin->assignRole('admin');
        } else {
            // Ensure barbershop_id is 1
            User::where('email', 'arga@gmail.com')->update(['barbershop_id' => 1]);
        }

        // Create User Admin (Toba Barbershop) if not exists
        if (!User::where('email', 'tobaadmin@gmail.com')->exists()) {
            $admin2 = User::create([
                'name' => 'Toba Admin',
                'email' => 'tobaadmin@gmail.com',
                'username' => 'tobaadmin',
                'password' => bcrypt('barber123'),
                'barbershop_id' => 2,
            ]);
            $admin2->assignRole('admin');
        }

        // Create third barbershop if not exists
        if (!DB::table('barber_shops')->where('id', 3)->exists()) {
            DB::table('barber_shops')->insert([
                'id' => 3,
                'nama' => 'Laguboti Barbershop',
                'slug' => 'laguboti-barbershop',
                'alamat' => 'Jl. Sisingamangaraja No. 102, Laguboti',
                'telepon' => '082111223344',
                'deskripsi' => 'Barbershop nyaman dengan pelayanan ramah di Laguboti.',
                'latitude' => 2.378900,
                'longitude' => 99.124500,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create User Admin (Laguboti Barbershop) if not exists
        if (!User::where('email', 'lagubotiadmin@gmail.com')->exists()) {
            $admin3 = User::create([
                'name' => 'Laguboti Admin',
                'email' => 'lagubotiadmin@gmail.com',
                'username' => 'lagubotiadmin',
                'password' => bcrypt('barber123'),
                'barbershop_id' => 3,
            ]);
            $admin3->assignRole('admin');
        }

        // 1. Data Layanan
        $this->call(LayananSeeder::class);

        // 2. Data Menu Kafe
        $this->call(MenuSeeder::class);

        // 3. Data Settings
        $this->call(SettingSeeder::class);

        // 4. Data Antrean
        $this->call(AntreanSeeder::class);

        // 5. Data Design
        $this->call(DesignSeeder::class);
    }
}
