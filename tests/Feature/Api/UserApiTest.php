<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_can_authenticate_via_api(): void
    {
        $user = User::factory()->create([
            'email' => 'api@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'api@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token', 'user']);
    }

    public function test_authenticated_user_can_get_me(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->getJson('/api/v1/me', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['id', 'name', 'email', 'status', 'roles']);
    }

    public function test_can_list_users_via_api(): void
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->getJson('/api/v1/users', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_unauthenticated_request_returns_401(): void
    {
        $response = $this->getJson('/api/v1/me');
        $response->assertUnauthorized();
    }

    public function test_invalid_login_returns_401(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_can_logout_via_api(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->postJson('/api/v1/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
    }
}
