<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin role
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Create an admin user
        $this->admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'username' => 'testadmin',
            'password' => bcrypt('password'),
        ]);
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_view_lokasi_settings_with_default_holiday_note(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.lokasi.index'));

        $response->assertStatus(200);
        $response->assertViewHas('keterangan_libur', 'libur');
        $response->assertSee('value="libur"', false);
    }

    public function test_admin_can_save_operational_holiday_status(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.lokasi.store'), [
                'latitude' => '2.33758',
                'longitude' => '99.079255',
                'radius_meters' => '100',
                'jam_buka' => '09:00',
                'jam_tutup' => '21:00',
                'keterangan_libur' => 'buka',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals('buka', Setting::get('queue_libur_note'));

        // Visit the setting view again to check if it displays the updated note as selected
        $viewResponse = $this->actingAs($this->admin)
            ->get(route('admin.lokasi.index'));
        $viewResponse->assertSee('value="buka" selected', false);
    }

    public function test_holiday_note_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.lokasi.store'), [
                'latitude' => '2.33758',
                'longitude' => '99.079255',
                'radius_meters' => '100',
                'jam_buka' => '09:00',
                'jam_tutup' => '21:00',
                'keterangan_libur' => 'invalid_value',
            ]);

        $response->assertSessionHasErrors('keterangan_libur');
    }

    public function test_landing_page_displays_correct_status_note(): void
    {
        // Default (libur)
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Libur pada Hari Raya');
        $response->assertDontSee('Tetap Buka pada Hari Raya');

        // Set to buka
        Setting::set('queue_libur_note', 'buka');

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Tetap Buka pada Hari Raya');
        $response->assertDontSee('Libur pada Hari Raya');
    }
}
