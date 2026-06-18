<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Barbershop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SuperAdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private $superAdmin;
    private $tenantAdmin;
    private $barbershop;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Roles
        Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Create a test barbershop
        $this->barbershop = Barbershop::create([
            'nama' => 'Cabang Balige',
            'slug' => 'cabang-balige',
            'is_active' => true,
        ]);

        // Create Super Admin
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'username' => 'superadmin',
            'password' => bcrypt('password'),
        ]);
        $this->superAdmin->assignRole('super_admin');

        // Create Tenant Admin
        $this->tenantAdmin = User::create([
            'name' => 'Tenant Admin',
            'email' => 'admin@test.com',
            'username' => 'tenantadmin',
            'password' => bcrypt('password'),
            'barbershop_id' => $this->barbershop->id,
        ]);
        $this->tenantAdmin->assignRole('admin');
    }

    public function test_guest_cannot_access_super_admin_dashboard(): void
    {
        $response = $this->get(route('super-admin.dashboard'));
        $response->assertRedirect('/login');
    }

    public function test_tenant_admin_cannot_access_super_admin_dashboard(): void
    {
        $response = $this->actingAs($this->tenantAdmin)
            ->get(route('super-admin.dashboard'));
            
        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('super-admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'totalBarbershops',
            'totalAdmins',
            'totalQueuesToday',
            'queuesMenunggu',
            'queuesSelesai',
            'queuesBatal',
            'barbershops'
        ]);
    }

    public function test_super_admin_can_create_barbershop(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->post(route('super-admin.barbershops.store'), [
                'nama' => 'Cabang Toba',
                'alamat' => 'Balige Raya',
                'telepon' => '082122223333',
                'latitude' => 2.3833,
                'longitude' => 99.1488,
                'is_active' => '1',
                'kategori' => 'barbershop',
                'warna_primer' => '#E8A53A',
            ]);

        $response->assertRedirect(route('super-admin.barbershops.index'));
        $this->assertDatabaseHas('barbershops', [
            'nama' => 'Cabang Toba',
            'slug' => 'cabang-toba',
            'is_active' => true,
            'kategori' => 'barbershop',
            'warna_primer' => '#E8A53A',
        ]);
    }

    public function test_super_admin_can_update_barbershop(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->put(route('super-admin.barbershops.update', $this->barbershop->id), [
                'nama' => 'Cabang Balige Updated',
                'slug' => 'cabang-balige-updated',
                'alamat' => 'Alamat baru',
                'is_active' => '1',
                'kategori' => 'salon',
                'warna_primer' => '#EC4899',
            ]);

        $response->assertRedirect(route('super-admin.barbershops.index'));
        $this->assertDatabaseHas('barbershops', [
            'id' => $this->barbershop->id,
            'nama' => 'Cabang Balige Updated',
            'slug' => 'cabang-balige-updated',
            'kategori' => 'salon',
            'warna_primer' => '#EC4899',
        ]);
    }

    public function test_super_admin_can_delete_barbershop(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->delete(route('super-admin.barbershops.destroy', $this->barbershop->id));

        $response->assertRedirect(route('super-admin.barbershops.index'));
        $this->assertDatabaseMissing('barbershops', [
            'id' => $this->barbershop->id,
        ]);
    }

    public function test_super_admin_can_create_admin_user(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->post(route('super-admin.admins.store'), [
                'name' => 'New Tenant Admin',
                'username' => 'newadmin',
                'email' => 'newadmin@test.com',
                'password' => 'password123',
                'barbershop_id' => $this->barbershop->id,
            ]);

        $response->assertRedirect(route('super-admin.admins.index'));
        $this->assertDatabaseHas('users', [
            'username' => 'newadmin',
            'email' => 'newadmin@test.com',
            'barbershop_id' => $this->barbershop->id,
        ]);

        $user = User::where('username', 'newadmin')->first();
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_super_admin_can_update_admin_user(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->put(route('super-admin.admins.update', $this->tenantAdmin->id), [
                'name' => 'Tenant Admin Updated',
                'username' => 'tenantadminupd',
                'email' => 'admin@test.com', // keep same
                'barbershop_id' => $this->barbershop->id,
            ]);

        $response->assertRedirect(route('super-admin.admins.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->tenantAdmin->id,
            'name' => 'Tenant Admin Updated',
            'username' => 'tenantadminupd',
        ]);
    }

    public function test_super_admin_can_delete_admin_user(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->delete(route('super-admin.admins.destroy', $this->tenantAdmin->id));

        $response->assertRedirect(route('super-admin.admins.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $this->tenantAdmin->id,
        ]);
    }

    public function test_super_admin_login_redirects_to_super_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'super@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/super-admin/dashboard');
    }

    public function test_super_admin_can_switch_tenant_context(): void
    {
        // 1. Switch context to the barbershop
        $response = $this->actingAs($this->superAdmin)
            ->get(route('super-admin.switch-tenant', $this->barbershop->id));

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals($this->barbershop->id, session('current_barbershop_id'));

        // 2. Clear context
        $response = $this->actingAs($this->superAdmin)
            ->get(route('super-admin.switch-tenant', 'clear'));

        $response->assertRedirect(route('super-admin.dashboard'));
        $this->assertFalse(session()->has('current_barbershop_id'));
    }

    public function test_super_admin_without_tenant_context_redirects_from_admin_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('super-admin.dashboard'));
    }
}
