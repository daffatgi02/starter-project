<div>
    <x-ui.page-header title="Users" description="Manage all users in the system.">
        <x-slot:actions>
            @can('create users')
                <x-ui.button variant="primary" href="{{ route('users.create') }}" icon="plus">
                    Add User
                </x-ui.button>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    {{-- Filters --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or email..."
                   class="form-input w-full" />
        </div>
        <select wire:model.live="filters.status" class="form-input w-full sm:w-44">
            <option value="">All Status</option>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
        <select wire:model.live="filters.role" class="form-input w-full sm:w-44">
            <option value="">All Roles</option>
            @foreach($roles as $value => $label)
                <option value="{{ $value }}">{{ ucfirst($label) }}</option>
            @endforeach
        </select>
    </div>

    {{-- Bulk bar --}}
    <div class="mt-4">
        <x-table.bulk-bar :selectedCount="count($selected)">
            @can('delete users')
                <x-ui.button variant="danger" size="sm" wire:click="bulkDelete" icon="trash">
                    Delete Selected
                </x-ui.button>
            @endcan
        </x-table.bulk-bar>
    </div>

    {{-- Table --}}
    <div class="mt-4">
        <x-ui.table>
            <thead class="bg-slate-50">
                <tr>
                    <th class="w-10 px-4 py-3">
                        <input type="checkbox" wire:model.live="selectAll" wire:click="toggleSelectAll"
                               class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                    </th>
                    <th class="px-4 py-3 text-left">
                        <x-table.sort-button field="name" :sortField="$sortField" :sortDirection="$sortDirection">
                            Name
                        </x-table.sort-button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-4 py-3 text-left">
                        <x-table.sort-button field="created_at" :sortField="$sortField" :sortDirection="$sortDirection">
                            Created
                        </x-table.sort-button>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rows as $user)
                    <tr wire:key="user-{{ $user->id }}" class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3">
                            <input type="checkbox" wire:model.live="selected" value="{{ $user->id }}"
                                   class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @foreach($user->roles as $role)
                                <x-ui.badge color="purple" icon="shield-check">{{ ucfirst($role->name) }}</x-ui.badge>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <x-ui.badge :color="$user->status->color()">{{ $user->status->label() }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <x-ui.dropdown>
                                <x-slot:trigger>
                                    <button type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                                        <x-ui.icon name="ellipsis-vertical" size="sm" />
                                    </button>
                                </x-slot:trigger>
                                @can('edit users')
                                    <a href="{{ route('users.edit', $user) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <x-ui.icon name="pencil-square" size="sm" class="text-slate-400" />
                                        Edit
                                    </a>
                                @endcan
                                @can('delete users')
                                    @if(auth()->id() !== $user->id)
                                        <button wire:click="confirmDelete('{{ $user->id }}')" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <x-ui.icon name="trash" size="sm" />
                                            Delete
                                        </button>
                                    @endif
                                @endcan
                            </x-ui.dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12">
                            <x-ui.empty-state title="No users found" description="Try adjusting your search or filters." icon="users" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

        <div class="mt-4">
            {{ $rows->links() }}
        </div>
    </div>
</div>
