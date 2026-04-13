<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(\App\Livewire\Profile\ProfileEdit::class)
            ->set('current_password', 'password')
            ->set('new_password', 'new-password')
            ->set('new_password_confirmation', 'new-password')
            ->call('updatePassword');

        $component->assertHasNoErrors();

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(\App\Livewire\Profile\ProfileEdit::class)
            ->set('current_password', 'wrong-password')
            ->set('new_password', 'new-password')
            ->set('new_password_confirmation', 'new-password')
            ->call('updatePassword');

        $component->assertHasErrors(['current_password']);
    }
}
