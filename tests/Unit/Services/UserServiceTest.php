<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->userService = app(UserService::class);
    }

    public function test_can_create_user_with_role(): void
    {
        $user = $this->userService->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_can_update_user_data(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
        ]);

        $updated = $this->userService->update($user, [
            'name' => 'Updated Name',
        ]);

        $this->assertEquals('Updated Name', $updated->name);
    }

    public function test_can_suspend_user(): void
    {
        $user = User::factory()->create([
            'status' => UserStatus::Active->value,
        ]);

        $suspended = $this->userService->suspend($user);

        $this->assertEquals(UserStatus::Suspended, $suspended->status);
    }

    public function test_can_activate_user(): void
    {
        $user = User::factory()->create([
            'status' => UserStatus::Suspended->value,
        ]);

        $activated = $this->userService->activate($user);

        $this->assertEquals(UserStatus::Active, $activated->status);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $result = $this->userService->delete($user);

        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_create_user_hashes_password(): void
    {
        $user = $this->userService->create([
            'name' => 'Hash Test',
            'email' => 'hash@example.com',
            'password' => 'plaintext123',
        ]);

        $this->assertNotEquals('plaintext123', $user->password);
    }
}
