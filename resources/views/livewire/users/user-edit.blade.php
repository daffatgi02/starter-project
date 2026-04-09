<div>
    <x-ui.page-header title="Edit User" description="Update user information.">
        <x-slot:actions>
            <x-ui.button variant="secondary" href="{{ route('users.index') }}" icon="arrow-left">
                Back
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <div class="mt-6 max-w-2xl">
        <x-ui.card>
            <form wire:submit="save" class="space-y-5">
                <x-form.input wire:model="name" id="name" label="Full Name" required :error="$errors->first('name')" />
                <x-form.input wire:model="email" id="email" label="Email Address" type="email" required :error="$errors->first('email')" />
                <x-form.input wire:model="password" id="password" label="New Password" type="password" placeholder="Leave empty to keep current" :error="$errors->first('password')" />
                <x-form.input wire:model="password_confirmation" id="password_confirmation" label="Confirm New Password" type="password" placeholder="Leave empty to keep current" />
                <x-form.select wire:model="status" id="status" label="Status" required :error="$errors->first('status')"
                    :options="collect($statuses)->mapWithKeys(fn($s) => [$s->value => $s->label()])->toArray()" />
                <x-form.select wire:model="role" id="role" label="Role" required :error="$errors->first('role')"
                    :options="$roles" />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-ui.button variant="secondary" href="{{ route('users.index') }}">Cancel</x-ui.button>
                    <x-ui.button variant="primary" type="submit" icon="check">Update User</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>
