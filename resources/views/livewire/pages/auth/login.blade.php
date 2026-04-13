<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function mount(): void
    {
        if (session('status')) {
            $this->dispatch('toast', type: 'success', message: session('status'));
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-form.input
                id="email"
                label="Email"
                type="email"
                wire:model="form.email"
                :required="true"
                :error="$errors->first('form.email')"
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
                wire:model="form.password"
                :required="true"
                :error="$errors->first('form.password')"
                autocomplete="current-password"
            />
        </div>

        <!-- Remember Me -->
        <div class="mt-4">
            <x-form.checkbox id="remember" label="Remember me" wire:model="form.remember" />
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-ui.button type="submit" class="ms-3">
                {{ __('Log in') }}
            </x-ui.button>
        </div>
    </form>
</div>
