<div>
    <x-ui.page-header title="Profile" description="Manage your account settings." />

    <div class="mt-6 max-w-2xl space-y-6">
        {{-- Profile Information --}}
        <x-ui.card>
            <x-slot:header>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="user" size="sm" class="text-slate-400" />
                    <h3 class="text-base font-semibold text-slate-900">Profile Information</h3>
                </div>
            </x-slot:header>
            <form wire:submit="updateProfile" class="space-y-5">
                <x-form.input wire:model="name" id="profile-name" label="Full Name" required :error="$errors->first('name')" />
                <x-form.input wire:model="email" id="profile-email" label="Email Address" type="email" required :error="$errors->first('email')" />
                <div class="flex justify-end pt-4 border-t border-slate-200">
                    <x-ui.button variant="primary" type="submit" icon="check">Save</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        {{-- Avatar --}}
        <x-ui.card>
            <x-slot:header>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="camera" size="sm" class="text-slate-400" />
                    <h3 class="text-base font-semibold text-slate-900">Avatar</h3>
                </div>
            </x-slot:header>
            <form wire:submit="uploadAvatar" class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-lg font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <x-form.file-upload wire:model="avatar" id="avatar" label="" accept="image/*" :error="$errors->first('avatar')" />
                </div>
                <div class="flex justify-end">
                    <x-ui.button variant="primary" type="submit" icon="arrow-up-tray">Upload</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        {{-- Password --}}
        <x-ui.card>
            <x-slot:header>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="lock-closed" size="sm" class="text-slate-400" />
                    <h3 class="text-base font-semibold text-slate-900">Change Password</h3>
                </div>
            </x-slot:header>
            <form wire:submit="updatePassword" class="space-y-5">
                <x-form.input wire:model="current_password" id="current_password" label="Current Password" type="password" required :error="$errors->first('current_password')" />
                <x-form.input wire:model="new_password" id="new_password" label="New Password" type="password" required :error="$errors->first('new_password')" />
                <x-form.input wire:model="new_password_confirmation" id="new_password_confirmation" label="Confirm New Password" type="password" required />
                <div class="flex justify-end pt-4 border-t border-slate-200">
                    <x-ui.button variant="primary" type="submit" icon="check">Update Password</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>
