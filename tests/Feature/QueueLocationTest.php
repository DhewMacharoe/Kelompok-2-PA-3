<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Antrean;
use App\Models\Layanan;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QueueLocationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default barbershop
        \Illuminate\Support\Facades\DB::table('barber_shops')->updateOrInsert(
            ['id' => 1],
            [
                'nama' => 'Arga Barbershop',
                'slug' => 'arga-barbershop',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Seed a default active service
        \Illuminate\Support\Facades\DB::table('layanans')->insert([
            [
                'id' => 18,
                'barbershop_id' => 1,
                'nama' => 'Hairwash & Style',
                'harga' => 30000,
                'estimasi_waktu' => '20',
                'deskripsi' => 'Hairwash and style',
                'is_active' => true,
            ],
        ]);

        // Set operational hours to always open during tests
        Setting::updateOrCreate(['key' => 'queue_jam_buka', 'barbershop_id' => 1], ['value' => '00:00']);
        Setting::updateOrCreate(['key' => 'queue_jam_tutup', 'barbershop_id' => 1], ['value' => '23:59']);

        // Set default queue location (Laguboti center roughly: 2.33758, 99.079255)
        Setting::updateOrCreate(['key' => 'queue_latitude', 'barbershop_id' => 1], ['value' => '2.33758']);
        Setting::updateOrCreate(['key' => 'queue_longitude', 'barbershop_id' => 1], ['value' => '99.079255']);
        Setting::updateOrCreate(['key' => 'queue_radius_meters', 'barbershop_id' => 1], ['value' => '100']);

        // Create a test user with 'user' role
        $this->user = User::create([
            'name' => 'Pelanggan Lokasi',
            'email' => 'pelanggan.lokasi@test.com',
            'username' => 'pelangganlokasi',
            'no_whatsapp' => '08123456789',
            'password' => bcrypt('password'),
            'barbershop_id' => 1,
        ]);
        $this->user->assignRole('user');

        // Set tenant context session
        $this->withSession([
            'current_barbershop_id' => 1,
            'current_barbershop_slug' => 'arga-barbershop',
            'current_barbershop_nama' => 'Arga Barbershop',
        ]);
    }

    /**
     * Test taking queue within the radius (e.g. 0 meters away at the exact location)
     */
    public function test_user_can_queue_when_within_radius(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
                'user_latitude' => 2.33758,
                'user_longitude' => 99.079255,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        
        $antrean = Antrean::where('nama_pelanggan', 'pelangganlokasi')->first();
        $this->assertNotNull($antrean);
        $this->assertEquals(18, $antrean->layanan_id1);
    }

    /**
     * Test taking queue slightly away but within radius (e.g. ~50 meters away)
     * Using coordinates close to 2.33758, 99.079255
     */
    public function test_user_can_queue_near_boundary_but_within_radius(): void
    {
        // ~50m away from 2.33758, 99.079255
        $userLat = 2.33758 + 0.0003; 
        $userLng = 99.079255 + 0.0003;

        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
                'user_latitude' => $userLat,
                'user_longitude' => $userLng,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        
        $antrean = Antrean::where('nama_pelanggan', 'pelangganlokasi')->first();
        $this->assertNotNull($antrean);
    }

    /**
     * Test taking queue outside the radius (e.g. 5 km away)
     */
    public function test_user_cannot_queue_when_outside_radius(): void
    {
        // Far away coordinates
        $userLat = 3.00000;
        $userLng = 100.00000;

        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
                'user_latitude' => $userLat,
                'user_longitude' => $userLng,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $errorMessage = session('error');
        $this->assertStringContainsString('Anda harus berada dalam radius maksimal 100 meter', $errorMessage);

        // Ensure no queue was created
        $antrean = Antrean::where('nama_pelanggan', 'pelangganlokasi')->first();
        $this->assertNull($antrean);
    }

    /**
     * Test when coordinates are missing
     */
    public function test_queue_location_validation_fails_with_missing_coordinates(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
            ]);

        $response->assertSessionHasErrors(['user_latitude', 'user_longitude']);
        
        // Ensure no queue was created
        $antrean = Antrean::where('nama_pelanggan', 'pelangganlokasi')->first();
        $this->assertNull($antrean);
    }

    /**
     * Test when coordinates are invalid (e.g. out of valid latitude/longitude bounds)
     */
    public function test_queue_location_validation_fails_with_invalid_coordinate_ranges(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('antrean.store'), [
                'layanan_id1' => 18,
                'user_latitude' => 120.0, // Latitude must be between -90 and 90
                'user_longitude' => -200.0, // Longitude must be between -180 and 180
            ]);

        $response->assertSessionHasErrors(['user_latitude', 'user_longitude']);
        
        // Ensure no queue was created
        $antrean = Antrean::where('nama_pelanggan', 'pelangganlokasi')->first();
        $this->assertNull($antrean);
    }
}
