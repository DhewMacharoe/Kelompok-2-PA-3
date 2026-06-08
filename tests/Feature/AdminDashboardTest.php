<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Antrean;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin role required by the route middleware
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
    }

    public function test_admin_dashboard_renders_successfully_with_correct_chart_data(): void
    {
        // 1. Create an admin user
        $admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'username' => 'testadmin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // 2. Insert some dummy queues for today to populate statistikData
        Antrean::create([
            'nomor_antrean_seq' => 1,
            'nama_pelanggan' => 'Customer 1',
            'status' => 'menunggu',
            'waktu_masuk' => now(),
            'created_at' => Carbon::today(),
        ]);
        Antrean::create([
            'nomor_antrean_seq' => 2,
            'nama_pelanggan' => 'Customer 2',
            'status' => 'selesai',
            'waktu_masuk' => now(),
            'created_at' => Carbon::today(),
        ]);
        Antrean::create([
            'nomor_antrean_seq' => 3,
            'nama_pelanggan' => 'Customer 3',
            'status' => 'batal',
            'waktu_masuk' => now(),
            'created_at' => Carbon::today(),
        ]);

        // 3. Make request acting as the admin
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));

        // 4. Assert response is successful
        $response->assertStatus(200);

        // 5. Assert variables are passed to the view
        $response->assertViewHas('statistikData');
        $response->assertViewHas('trendLabels');
        $response->assertViewHas('trendData');

        // 6. Verify data structures
        $statistikData = $response->viewData('statistikData');
        $trendLabels = $response->viewData('trendLabels');
        $trendData = $response->viewData('trendData');

        $this->assertIsArray($statistikData);
        $this->assertCount(3, $statistikData);
        // [menunggu, selesai, batal]
        $this->assertEquals(1, $statistikData[0]); // menunggu
        $this->assertEquals(1, $statistikData[1]); // selesai
        $this->assertEquals(1, $statistikData[2]); // batal

        $this->assertIsArray($trendLabels);
        $this->assertCount(7, $trendLabels);

        $this->assertIsArray($trendData);
        $this->assertCount(7, $trendData);
        $this->assertEquals(3, $trendData[6]); // Today's count (last element in 7-day trend)
    }
}
