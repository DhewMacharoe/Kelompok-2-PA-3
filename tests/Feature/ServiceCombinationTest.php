<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Antrean;
use App\Models\Layanan;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ServiceCombinationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Seed layanans directly
        \Illuminate\Support\Facades\DB::table('layanans')->insert([
            [
                'id' => 11,
                'nama' => 'Regular',
                'harga' => 60000,
                'estimasi_waktu' => '60',
                'deskripsi' => 'Haircut, hairwash, styling',
                'is_active' => true,
            ],
            [
                'id' => 14,
                'nama' => 'Bald',
                'harga' => 60000,
                'estimasi_waktu' => '45',
                'deskripsi' => 'Complete head shave',
                'is_active' => true,
            ],
            [
                'id' => 16,
                'nama' => 'Face Facial',
                'harga' => 30000,
                'estimasi_waktu' => '30',
                'deskripsi' => 'Refreshing facial',
                'is_active' => true,
            ],
            [
                'id' => 17,
                'nama' => 'Coloring Basic / Fashion',
                'harga' => 100000,
                'estimasi_waktu' => '60',
                'deskripsi' => 'Coloring',
                'is_active' => true,
            ],
            [
                'id' => 18,
                'nama' => 'Hairwash & Style',
                'harga' => 30000,
                'estimasi_waktu' => '20',
                'deskripsi' => 'Hairwash and style',
                'is_active' => true,
            ],
        ]);

        // Seed package service combinations directly
        \Illuminate\Support\Facades\DB::table('package_service')->insert([
            ['package_id' => 11, 'service_id' => 16],
            ['package_id' => 11, 'service_id' => 18],
        ]);

        // Seed incompatibilities directly
        \Illuminate\Support\Facades\DB::table('incompatibilities')->insert([
            [
                'service_id_a' => 14,
                'service_id_b' => 17,
                'deskripsi_konflik' => 'Layanan Botak/Gundul tidak dapat digabungkan dengan Cat Rambut.',
            ]
        ]);

        // 2. Set operational hours and radius in settings to allow queue creation
        Setting::updateOrCreate(['key' => 'queue_jam_buka'], ['value' => '00:00']);
        Setting::updateOrCreate(['key' => 'queue_jam_tutup'], ['value' => '23:59']);
        Setting::updateOrCreate(['key' => 'queue_latitude'], ['value' => '2.33758']);
        Setting::updateOrCreate(['key' => 'queue_longitude'], ['value' => '99.079255']);
        Setting::updateOrCreate(['key' => 'queue_radius_meters'], ['value' => '500']);

        // 3. Create a test user with the 'user' role
        $this->user = User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@test.com',
            'username' => 'pelanggantest',
            'password' => bcrypt('password'),
        ]);
        $this->user->assignRole('user');
    }

    /**
     * Skenario Valid: Styling saja (ID 18)
     */
    public function test_valid_styling_only(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        
        // Assert queue is stored
        $antrean = Antrean::where('nama_pelanggan', 'pelanggantest')->first();
        $this->assertNotNull($antrean);
        $this->assertEquals(18, $antrean->layanan_id1);
        $this->assertNull($antrean->layanan_id2);

        // Assert price and duration
        $this->assertEquals(30000, $antrean->totalPemasukanRekap());
        $this->assertEquals(20, $antrean->total_estimasi_waktu);
    }

    /**
     * Skenario Valid: Paket Reguler (ID 11)
     */
    public function test_valid_paket_reguler(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 11,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $antrean = Antrean::where('nama_pelanggan', 'pelanggantest')->first();
        $this->assertNotNull($antrean);
        $this->assertEquals(11, $antrean->layanan_id1);

        // Assert price and duration
        $this->assertEquals(60000, $antrean->totalPemasukanRekap());
        $this->assertEquals(60, $antrean->total_estimasi_waktu);
    }

    /**
     * Skenario Valid: Paket Reguler (ID 11) + Cat Rambut (ID 17)
     */
    public function test_valid_paket_reguler_and_cat_rambut(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 11,
                'layanan_id2' => 17,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $antrean = Antrean::where('nama_pelanggan', 'pelanggantest')->first();
        $this->assertNotNull($antrean);
        $this->assertEquals(11, $antrean->layanan_id1);
        $this->assertEquals(17, $antrean->layanan_id2);

        // Price: Paket Reguler (60000) + Cat Rambut (100000) = 160000
        $this->assertEquals(160000, $antrean->totalPemasukanRekap());
        // Duration: Paket Reguler (60) + Cat Rambut (60) = 120 minutes
        $this->assertEquals(120, $antrean->total_estimasi_waktu);
    }

    /**
     * Skenario Tidak Valid: Paket Reguler (ID 11) + Styling (ID 18)
     */
    public function test_invalid_paket_reguler_and_styling(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 11,
                'layanan_id2' => 18,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHas('error');
        $errorMessage = session('error');
        $this->assertStringContainsString('sudah termasuk dalam paket', $errorMessage);

        // Assert no queue was created
        $antrean = Antrean::where('nama_pelanggan', 'pelanggantest')->first();
        $this->assertNull($antrean);
    }

    /**
     * Skenario Tidak Valid: Botak (ID 14) + Cat Rambut (ID 17)
     */
    public function test_invalid_botak_and_cat_rambut(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 14,
                'layanan_id2' => 17,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHas('error');
        $errorMessage = session('error');
        $this->assertStringContainsString('Layanan Botak/Gundul tidak dapat digabungkan dengan Cat Rambut.', $errorMessage);

        // Assert no queue was created
        $antrean = Antrean::where('nama_pelanggan', 'pelanggantest')->first();
        $this->assertNull($antrean);
    }
}
