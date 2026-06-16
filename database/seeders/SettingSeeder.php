<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $settings = [
            [
                'id' => 1,
                'key' => 'queue_latitude',
                'value' => '2.386130',
                'created_at' => '2026-06-01 18:58:17',
                'updated_at' => '2026-06-13 10:48:46',
            ],
            [
                'id' => 2,
                'key' => 'queue_longitude',
                'value' => '99.147852',
                'created_at' => '2026-06-01 18:58:17',
                'updated_at' => '2026-06-13 10:48:46',
            ],
            [
                'id' => 3,
                'key' => 'queue_radius_meters',
                'value' => '360',
                'created_at' => '2026-06-01 18:58:17',
                'updated_at' => '2026-06-15 01:50:01',
            ],
            [
                'id' => 4,
                'key' => 'queue_jam_buka',
                'value' => '00:00',
                'created_at' => '2026-06-10 08:11:40',
                'updated_at' => '2026-06-11 18:16:20',
            ],
            [
                'id' => 5,
                'key' => 'queue_jam_tutup',
                'value' => '23:00',
                'created_at' => '2026-06-10 08:11:40',
                'updated_at' => '2026-06-11 18:16:05',
            ],
            [
                'id' => 6,
                'key' => 'queue_libur_note',
                'value' => 'libur',
                'created_at' => '2026-06-16 08:00:00',
                'updated_at' => '2026-06-16 08:00:00',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
