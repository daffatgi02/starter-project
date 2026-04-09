<div>
    <x-ui.page-header title="Activity Logs" description="View all system activity." />

    <div class="mt-6">
        <div class="mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search events, descriptions, users..."
                   class="form-input w-full max-w-md" />
        </div>

        <x-ui.table>
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <x-table.sort-button field="event" :sortField="$sortField" :sortDirection="$sortDirection">Event</x-table.sort-button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">IP</th>
                    <th class="px-4 py-3 text-left">
                        <x-table.sort-button field="created_at" :sortField="$sortField" :sortDirection="$sortDirection">Date</x-table.sort-button>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3">
                            <x-ui.badge :color="match($log->event) { 'created' => 'green', 'updated' => 'blue', 'deleted' => 'red', 'login' => 'purple', default => 'gray' }">
                                {{ $log->event }}
                            </x-ui.badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-700 max-w-md truncate">{{ $log->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-500 font-mono">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12">
                            <x-ui.empty-state title="No activity logs" description="Activity will appear here once users start interacting." icon="clipboard-document-list" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
