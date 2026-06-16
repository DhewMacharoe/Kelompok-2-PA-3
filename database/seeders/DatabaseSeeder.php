<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Create Roles
        if (!Role::where('name', 'admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
        }

        // Create User Admin if not exists
        if (!User::where('email', 'arga@gmail.com')->exists()) {
            $admin = User::create([
                'name' => 'Arga Admin',
                'email' => 'arga@gmail.com',
                'username' => 'argaadmin',
                'password' => bcrypt('barber123'),
            ]);
            $admin->role_id = 1;
            $admin->save();
            $admin->assignRole('admin');
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
