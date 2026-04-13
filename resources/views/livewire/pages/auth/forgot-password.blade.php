<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function mount(): void
    {
        if (session('status')) {
            $this->dispatch('toast', type: 'success', message: session('status'));
        }
    }

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        $this->dispatch('toast', type: 'success', message: __($status));
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-slate-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-form.input
                id="email"
                label="Email"
                type="email"
                wire:model="email"
                :required="true"
                :error="$errors->first('email')"
                autofocus
            />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-ui.button type="submit">
                {{ __('Email Password Reset Link') }}
            </x-ui.button>
        </div>
    </form>
</div>
