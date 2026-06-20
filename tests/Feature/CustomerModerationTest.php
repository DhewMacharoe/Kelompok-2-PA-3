<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Antrean;
use App\Models\Layanan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class CustomerModerationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;
    protected $layanan;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        if (!Role::where('name', 'admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
        }

        // Create barbershop
        \App\Models\Barbershop::create([
            'id' => 1,
            'nama' => 'Arga Barbershop',
            'slug' => 'arga-barbershop',
            'is_active' => true,
        ]);

        // Create admin
        $this->admin = User::create([
            'name' => 'Arga Admin',
            'email' => 'arga@gmail.com',
            'username' => 'argaadmin',
            'password' => bcrypt('barber123'),
            'barbershop_id' => 1,
        ]);
        $this->admin->assignRole('admin');

        // Create customer
        $this->customer = User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@gmail.com',
            'username' => 'pelanggantest',
            'password' => bcrypt('password123'),
            'no_whatsapp' => '081234567890',
        ]);
        $this->customer->assignRole('user');

        // Create active service
        $this->layanan = Layanan::create([
            'nama' => 'Potong Rambut',
            'harga' => 30000,
            'estimasi_waktu' => 30,
            'is_active' => true,
            'barbershop_id' => 1,
        ]);
    }

    public function test_risk_level_calculations()
    {
        // Initially, 0 bookings = low risk
        $this->assertEquals(0, $this->customer->totalBookings());
        $this->assertEquals('low', $this->customer->riskLevel());

        // Create 2 completed bookings -> low risk
        for ($i = 0; $i < 2; $i++) {
            Antrean::create([
                'user_id' => $this->customer->id,
                'nomor_antrean_seq' => $i + 1,
                'nama_pelanggan' => $this->customer->username,
                'layanan_id1' => $this->layanan->id,
                'status' => 'selesai',
                'is_booking' => true,
                'tanggal_booking' => Carbon::now()->toDateString(),
                'waktu_booking' => '10:00',
                'barbershop_id' => 1,
            ]);
        }
        $this->assertEquals('low', $this->customer->riskLevel());

        // Add 1 cancellation by customer -> medium risk (total=3, cancel=1, pct=33.3%)
        Antrean::create([
            'user_id' => $this->customer->id,
            'nomor_antrean_seq' => 3,
            'nama_pelanggan' => $this->customer->username,
            'layanan_id1' => $this->layanan->id,
            'status' => 'batal',
            'batal_oleh' => 'pelanggan',
            'is_booking' => true,
            'tanggal_booking' => Carbon::now()->toDateString(),
            'waktu_booking' => '11:00',
            'barbershop_id' => 1,
        ]);
        $this->assertEquals('medium', $this->customer->riskLevel());

        // Add 2nd cancellation by customer -> high risk (total=4, cancel=2, pct=50%)
        Antrean::create([
            'user_id' => $this->customer->id,
            'nomor_antrean_seq' => 4,
            'nama_pelanggan' => $this->customer->username,
            'layanan_id1' => $this->layanan->id,
            'status' => 'batal',
            'batal_oleh' => 'pelanggan',
            'is_booking' => true,
            'tanggal_booking' => Carbon::now()->toDateString(),
            'waktu_booking' => '11:30',
            'barbershop_id' => 1,
        ]);
        $this->assertEquals('high', $this->customer->riskLevel());

        // Add 3rd cancellation -> high risk (total=5, cancel=3, pct=60%)
        Antrean::create([
            'user_id' => $this->customer->id,
            'nomor_antrean_seq' => 5,
            'nama_pelanggan' => $this->customer->username,
            'layanan_id1' => $this->layanan->id,
            'status' => 'batal',
            'batal_oleh' => 'pelanggan',
            'is_booking' => true,
            'tanggal_booking' => Carbon::now()->toDateString(),
            'waktu_booking' => '12:00',
            'barbershop_id' => 1,
        ]);
        $this->assertEquals('high', $this->customer->riskLevel());
    }

    public function test_blocked_customer_cannot_book()
    {
        // Block customer
        $this->customer->update([
            'is_blocked' => true,
            'blocked_reason' => 'Sering membatalkan booking',
            'blocked_at' => now(),
        ]);

        $this->actingAs($this->customer);

        // Make booking request
        $response = $this->post('/arga-barbershop/antrean', [
            'layanan_id1' => $this->layanan->id,
            'is_booking' => '1',
            'tanggal_booking' => Carbon::now()->addDay()->toDateString(),
            'waktu_booking' => '10:00',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Akun Anda ditangguhkan', session('error'));
    }

    public function test_risk_reset()
    {
        // Create 3 customer cancellations -> high risk
        for ($i = 0; $i < 3; $i++) {
            Antrean::create([
                'user_id' => $this->customer->id,
                'nomor_antrean_seq' => $i + 1,
                'nama_pelanggan' => $this->customer->username,
                'layanan_id1' => $this->layanan->id,
                'status' => 'batal',
                'batal_oleh' => 'pelanggan',
                'is_booking' => true,
                'tanggal_booking' => Carbon::now()->toDateString(),
                'waktu_booking' => '10:00',
                'barbershop_id' => 1,
            ]);
        }
        $this->assertEquals('high', $this->customer->riskLevel());

        // Reset risk
        $this->customer->update([
            'reset_risk_at' => now(),
        ]);

        // Risk should now be low (0 bookings, 0 cancellations counted)
        $this->assertEquals(0, $this->customer->totalBookings());
        $this->assertEquals('low', $this->customer->riskLevel());
    }
}
