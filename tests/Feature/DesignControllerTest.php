<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Design;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DesignControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Design $design;

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

        // Create the admin role
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Create an admin user
        $this->admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'username' => 'testadmin',
            'password' => bcrypt('password'),
            'barbershop_id' => 1,
        ]);
        $this->admin->assignRole('admin');

        // Create initial design
        $this->design = Design::create([
            'barbershop_id' => 1,
            'is_active' => true,
            'nama_brand' => "Arga Home's",
            'favicon' => 'assets/images/logo.png',
            'alaamat' => 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara',
            'email' => 'joebarberid@gmail.com',
            'slogan' => 'Barber, Coffee & Food',
            'warna_primer' => '#e8a53a',
            'kontak' => [
                'instagram' => 'https://instagram.com',
                'facebook' => 'https://facebook.com',
                'whatsapp' => '082167893019',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.386130,99.147852',
                'map_embed' => 'https://maps.google.com/maps?q=2.386130,99.147852&z=15&output=embed',
            ],
        ]);
    }

    public function test_admin_can_view_design_settings(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.design.index'));

        $response->assertStatus(200);
        $response->assertSee("Arga Home&#039;s", false);
        $response->assertSee("Google Maps Sematan", false);
    }

    public function test_admin_can_view_edit_design_page_with_map_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.design.edit', $this->design->id));

        $response->assertStatus(200);
        $response->assertSee('Link Google Maps (Tombol Navigasi)', false);
        $response->assertSee('URL Embed Peta (Iframe Preview)', false);
        $response->assertSee('query=2.386130,99.147852', false);
    }

    public function test_admin_can_update_design_settings_including_maps(): void
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.design.update', $this->design->id), [
                'nama_brand' => 'New Brand Name',
                'alaamat' => 'New Address Road',
                'email' => 'new@brand.com',
                'whatsapp' => '08123456789',
                'instagram' => 'https://instagram.com/new',
                'facebook' => 'https://facebook.com/new',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.456,99.789',
                'map_embed' => 'https://maps.google.com/maps?q=2.456,99.789&z=15&output=embed',
                'warna_primer' => '#ff0000',
                'slogan' => 'New Slogan',
                'deskripsi_hero' => 'New Hero Description Text',
                'judul_hero_layanan' => 'New Layanan Hero Title',
                'deskripsi_hero_layanan' => 'New Layanan Hero Desc',
                'judul_hero_galeri' => 'New Galeri Hero Title',
                'deskripsi_hero_galeri' => 'New Galeri Hero Desc',
                'judul_hero_menu' => 'New Menu Hero Title',
                'deskripsi_hero_menu' => 'New Menu Hero Desc',
            ]);

        $response->assertRedirect(route('admin.design.index'));
        $response->assertSessionHas('success');

        $this->design->refresh();
        $this->assertEquals('New Brand Name', $this->design->nama_brand);
        $this->assertEquals('New Hero Description Text', $this->design->deskripsi_hero);
        $this->assertEquals('New Layanan Hero Title', $this->design->judul_hero_layanan);
        $this->assertEquals('New Layanan Hero Desc', $this->design->deskripsi_hero_layanan);
        $this->assertEquals('https://www.google.com/maps/search/?api=1&query=2.456,99.789', $this->design->kontak['link_map']);
        $this->assertEquals('https://maps.google.com/maps?q=2.456,99.789&z=15&output=embed', $this->design->kontak['map_embed']);
    }

    public function test_admin_can_update_design_settings_with_hero_image(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->image('hero.jpg');
        $fileLayanan = \Illuminate\Http\UploadedFile::fake()->image('hero_layanan.jpg');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.design.update', $this->design->id), [
                'nama_brand' => 'New Brand Name',
                'alaamat' => 'New Address Road',
                'email' => 'new@brand.com',
                'whatsapp' => '08123456789',
                'instagram' => 'https://instagram.com/new',
                'facebook' => 'https://facebook.com/new',
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.456,99.789',
                'map_embed' => 'https://maps.google.com/maps?q=2.456,99.789&z=15&output=embed',
                'warna_primer' => '#ff0000',
                'slogan' => 'New Slogan',
                'deskripsi_hero' => 'New Hero Description Text',
                'gambar_hero' => $file,
                'judul_hero_layanan' => 'New Layanan Hero Title',
                'deskripsi_hero_layanan' => 'New Layanan Hero Desc',
                'gambar_hero_layanan' => $fileLayanan,
                'judul_hero_galeri' => 'New Galeri Hero Title',
                'deskripsi_hero_galeri' => 'New Galeri Hero Desc',
                'judul_hero_menu' => 'New Menu Hero Title',
                'deskripsi_hero_menu' => 'New Menu Hero Desc',
            ]);

        $response->assertRedirect(route('admin.design.index'));
        $response->assertSessionHas('success');

        $this->design->refresh();
        $this->assertNotNull($this->design->gambar_hero);
        $this->assertFileExists(public_path($this->design->gambar_hero));
        $this->assertNotNull($this->design->gambar_hero_layanan);
        $this->assertFileExists(public_path($this->design->gambar_hero_layanan));

        // Clean up the uploaded fake files
        if (file_exists(public_path($this->design->gambar_hero))) {
            @unlink(public_path($this->design->gambar_hero));
        }
        if (file_exists(public_path($this->design->gambar_hero_layanan))) {
            @unlink(public_path($this->design->gambar_hero_layanan));
        }
    }

    public function test_reset_location_in_lokasi_page_uses_active_design_map_link(): void
    {
        // Set a custom link map on active design
        $this->design->update([
            'kontak' => array_merge($this->design->kontak, [
                'link_map' => 'https://www.google.com/maps/search/?api=1&query=2.55555,99.66666'
            ])
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.lokasi.index'));

        $response->assertStatus(200);
        // Verify it includes the active design's link in the JS response
        $response->assertSee('query=2.55555,99.66666', false);
    }
}
