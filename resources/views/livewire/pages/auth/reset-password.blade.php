<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <form wire:submit="resetPassword">
        <!-- Email Address -->
        <div>
            <x-form.input
                id="email"
                label="Email"
                type="email"
                wire:model="email"
                :required="true"
                :error="$errors->first('email')"
                autocomplete="username"
                autofocus
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
            <x-ui.button type="submit">
                {{ __('Reset Password') }}
            </x-ui.button>
        </div>
    </form>
</div>
