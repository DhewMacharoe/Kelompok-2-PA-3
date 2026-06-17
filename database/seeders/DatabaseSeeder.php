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

        // Call BarbershopSeeder FIRST to ensure the tenant rows exist before creating Users
        $this->call(BarbershopSeeder::class);





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
    }
}
