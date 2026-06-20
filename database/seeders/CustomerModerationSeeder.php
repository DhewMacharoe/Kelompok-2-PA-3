<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Antrean;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerModerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure user role exists
        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
        }

        // Clean existing test customers if they exist
        $emails = ['hijau@gmail.com', 'kuning@gmail.com', 'merah@gmail.com', 'blocked@gmail.com'];
        $existingUsers = User::whereIn('email', $emails)->get();
        foreach ($existingUsers as $u) {
            Antrean::where('user_id', $u->id)->delete();
            $u->delete();
        }

        // Get a valid active service ID
        $layananId = DB::table('layanans')->where('is_active', true)->value('id');
        if (!$layananId) {
            $layananId = DB::table('layanans')->value('id') ?? 1;
        }

        // Barbershop ID for Arga Barbershop
        $barbershopId = 1;

        // 1. Create Pelanggan Hijau (Low Risk: 5 Bookings, 0 Cancellations)
        $userHijau = User::create([
            'name' => 'Pelanggan Hijau',
            'email' => 'hijau@gmail.com',
            'username' => 'pelanggan_hijau',
            'password' => bcrypt('password123'),
            'no_whatsapp' => '081234567890',
            'barbershop_id' => null, // null for customers, so they can book anywhere
        ]);
        $userHijau->assignRole('user');

        for ($i = 1; $i <= 5; $i++) {
            $date = Carbon::now()->subDays($i);
            Antrean::create([
                'user_id' => $userHijau->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userHijau->username,
                'layanan_id1' => $layananId,
                'status' => 'selesai',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '10:00',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(10, 0),
                'waktu_selesai' => $date->copy()->setTime(10, 30),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // 2. Create Pelanggan Kuning (Medium Risk: 5 Bookings, 2 Cancellations)
        $userKuning = User::create([
            'name' => 'Pelanggan Kuning',
            'email' => 'kuning@gmail.com',
            'username' => 'pelanggan_kuning',
            'password' => bcrypt('password123'),
            'no_whatsapp' => '081234567891',
            'barbershop_id' => null,
        ]);
        $userKuning->assignRole('user');

        // 3 completed
        for ($i = 1; $i <= 3; $i++) {
            $date = Carbon::now()->subDays($i + 5);
            Antrean::create([
                'user_id' => $userKuning->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userKuning->username,
                'layanan_id1' => $layananId,
                'status' => 'selesai',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '11:00',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(11, 0),
                'waktu_selesai' => $date->copy()->setTime(11, 30),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        // 2 canceled by customer
        for ($i = 4; $i <= 5; $i++) {
            $date = Carbon::now()->subDays($i + 5);
            Antrean::create([
                'user_id' => $userKuning->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userKuning->username,
                'layanan_id1' => $layananId,
                'status' => 'batal',
                'batal_oleh' => 'pelanggan',
                'alasan_batal' => 'Ada keperluan mendadak',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '14:00',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(14, 0),
                'waktu_selesai' => $date->copy()->setTime(14, 15),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // 3. Create Pelanggan Merah (High Risk: 5 Bookings, 3 Customer Cancellations, 1 No-Show)
        $userMerah = User::create([
            'name' => 'Pelanggan Merah',
            'email' => 'merah@gmail.com',
            'username' => 'pelanggan_merah',
            'password' => bcrypt('password123'),
            'no_whatsapp' => '081234567892',
            'barbershop_id' => null,
        ]);
        $userMerah->assignRole('user');

        // 1 completed
        $date = Carbon::now()->subDays(15);
        Antrean::create([
            'user_id' => $userMerah->id,
            'nomor_antrean_seq' => 1,
            'nama_pelanggan' => $userMerah->username,
            'layanan_id1' => $layananId,
            'status' => 'selesai',
            'is_booking' => true,
            'tanggal_booking' => $date->toDateString(),
            'waktu_booking' => '12:00',
            'barbershop_id' => $barbershopId,
            'waktu_masuk' => $date->copy()->setTime(12, 0),
            'waktu_selesai' => $date->copy()->setTime(12, 30),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // 3 customer cancellations
        for ($i = 2; $i <= 4; $i++) {
            $date = Carbon::now()->subDays($i + 15);
            Antrean::create([
                'user_id' => $userMerah->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userMerah->username,
                'layanan_id1' => $layananId,
                'status' => 'batal',
                'batal_oleh' => 'pelanggan',
                'alasan_batal' => 'Malas keluar rumah',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '13:00',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(13, 0),
                'waktu_selesai' => $date->copy()->setTime(13, 10),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // 1 no-show
        $date = Carbon::now()->subDays(20);
        Antrean::create([
            'user_id' => $userMerah->id,
            'nomor_antrean_seq' => 5,
            'nama_pelanggan' => $userMerah->username,
            'layanan_id1' => $layananId,
            'status' => 'batal',
            'batal_oleh' => 'no_show',
            'alasan_batal' => 'Pelanggan tidak hadir di lokasi saat dipanggil',
            'is_booking' => true,
            'tanggal_booking' => $date->toDateString(),
            'waktu_booking' => '15:30',
            'barbershop_id' => $barbershopId,
            'waktu_masuk' => $date->copy()->setTime(15, 30),
            'waktu_selesai' => $date->copy()->setTime(15, 45),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // 4. Create Pelanggan Blocked (Blocked Customer with 4 cancellations)
        $userBlocked = User::create([
            'name' => 'Pelanggan Terblokir',
            'email' => 'blocked@gmail.com',
            'username' => 'pelanggan_blocked',
            'password' => bcrypt('password123'),
            'no_whatsapp' => '081234567893',
            'barbershop_id' => null,
            'is_blocked' => true,
            'blocked_reason' => 'Melakukan pembatalan booking berulang kali secara tidak wajar.',
            'blocked_at' => Carbon::now()->subDays(1),
        ]);
        $userBlocked->assignRole('user');

        // 2 completed
        for ($i = 1; $i <= 2; $i++) {
            $date = Carbon::now()->subDays($i + 30);
            Antrean::create([
                'user_id' => $userBlocked->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userBlocked->username,
                'layanan_id1' => $layananId,
                'status' => 'selesai',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '09:30',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(9, 30),
                'waktu_selesai' => $date->copy()->setTime(10, 0),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // 4 cancellations by customer
        for ($i = 3; $i <= 6; $i++) {
            $date = Carbon::now()->subDays($i + 30);
            Antrean::create([
                'user_id' => $userBlocked->id,
                'nomor_antrean_seq' => $i,
                'nama_pelanggan' => $userBlocked->username,
                'layanan_id1' => $layananId,
                'status' => 'batal',
                'batal_oleh' => 'pelanggan',
                'alasan_batal' => 'Salah klik jam booking',
                'is_booking' => true,
                'tanggal_booking' => $date->toDateString(),
                'waktu_booking' => '16:00',
                'barbershop_id' => $barbershopId,
                'waktu_masuk' => $date->copy()->setTime(16, 0),
                'waktu_selesai' => $date->copy()->setTime(16, 10),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
