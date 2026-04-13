<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-form.input
                id="name"
                label="Name"
                type="text"
                wire:model="name"
                :required="true"
                :error="$errors->first('name')"
                autocomplete="name"
                autofocus
            />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-form.input
                id="email"
                label="Email"
                type="email"
                wire:model="email"
                :required="true"
                :error="$errors->first('email')"
                autocomplete="username"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-form.input
                id="password"
                label="Password"
                type="password"
                wire:model="password"
                :required="true"
                :error="$errors->first('password')"
                autocomplete="new-password"
            />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-form.input
                id="password_confirmation"
                label="Confirm Password"
                type="password"
                wire:model="password_confirmation"
                :required="true"
                :error="$errors->first('password_confirmation')"
                autocomplete="new-password"
            />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-ui.button type="submit" class="ms-4">
                {{ __('Register') }}
            </x-ui.button>
        </div>
    </form>
</div>
