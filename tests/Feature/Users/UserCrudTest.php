<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super-admin');
    }

    public function test_super_admin_can_view_users_list(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_view_create_user_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('users.create'));
        $response->assertStatus(200);
    }

    public function test_user_without_permission_cannot_access_users(): void
    {
        $regularUser = User::factory()->create();

        $response = $this->actingAs($regularUser)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_access_roles_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('roles.index'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_access_settings_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('settings.index'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_access_activity_logs(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('activity-logs.index'));
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }
}
