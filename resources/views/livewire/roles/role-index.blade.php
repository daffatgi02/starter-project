<div>
    <x-ui.page-header title="Roles & Permissions" description="Manage roles and their permissions." />

    <div class="mt-6 space-y-6">
        @foreach($roles as $role)
            <x-ui.card>
                <x-slot:header>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <x-ui.icon name="shield-check" size="sm" class="text-primary-600" />
                            <h3 class="text-base font-semibold text-slate-900">{{ ucfirst($role->name) }}</h3>
                            <x-ui.badge color="blue">{{ $role->permissions->count() }} permissions</x-ui.badge>
                        </div>
                        @can('edit roles')
                            @if($editingRoleId !== (string) $role->id)
                                <x-ui.button variant="ghost" size="sm" wire:click="editRole('{{ $role->id }}')" icon="pencil-square">
                                    Edit
                                </x-ui.button>
                            @endif
                        @endcan
                    </div>
                </x-slot:header>

                @if($editingRoleId === (string) $role->id)
                    <div class="space-y-4">
                        @foreach($allPermissions as $group => $permissions)
                            <div>
                                <h4 class="text-sm font-semibold text-slate-700 capitalize mb-2">{{ $group }}</h4>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox"
                                                   wire:model.live="editingPermissions"
                                                   value="{{ $permission->name }}"
                                                   class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                                                   @if($role->name === 'super-admin') disabled @endif />
                                            <span class="text-sm text-slate-600">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                            <x-ui.button variant="secondary" size="sm" wire:click="cancelEdit">Cancel</x-ui.button>
                            <x-ui.button variant="primary" size="sm" wire:click="updateRole" icon="check">Save Permissions</x-ui.button>
                        </div>
                    </div>
                @else
                    <div class="flex flex-wrap gap-2">
                        @forelse($role->permissions as $perm)
                            <x-ui.badge color="gray" icon="lock-closed">{{ $perm->name }}</x-ui.badge>
                        @empty
                            <span class="text-sm text-slate-400">No permissions assigned</span>
                        @endforelse
                    </div>
                @endif
            </x-ui.card>
        @endforeach
    </div>
</div>
