<div>
    <x-ui.page-header title="Dashboard" description="Overview of your application." />

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($stats as $stat)
            <x-ui.stat-card
                :title="$stat['title']"
                :value="$stat['value']"
                :icon="$stat['icon']"
                :change="$stat['change']"
                :changeType="$stat['changeType']"
                :color="$stat['color']"
            />
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Recent Activity --}}
        <x-ui.card>
            <x-slot:header>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="clipboard-document-list" size="sm" class="text-slate-400" />
                    <h3 class="text-base font-semibold text-slate-900">Recent Activity</h3>
                </div>
            </x-slot:header>

            @php $recentLogs = \App\Models\ActivityLog::with('user')->latest()->limit(5)->get(); @endphp
            @forelse($recentLogs as $log)
                <div class="flex items-center gap-3 py-3 @if(!$loop->last) border-b border-slate-100 @endif">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 flex-shrink-0">
                        <x-ui.icon name="clock" size="xs" class="text-slate-500" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-slate-700 truncate">{{ $log->description ?? $log->event }}</p>
                        <p class="text-xs text-slate-400">{{ $log->user?->name ?? 'System' }} &middot; {{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="No activity yet" description="Activity will appear here once users start interacting." icon="clipboard-document-list" />
            @endforelse
        </x-ui.card>

        {{-- Quick Stats --}}
        <x-ui.card>
            <x-slot:header>
                <div class="flex items-center gap-2">
                    <x-ui.icon name="users" size="sm" class="text-slate-400" />
                    <h3 class="text-base font-semibold text-slate-900">Latest Users</h3>
                </div>
            </x-slot:header>

            @php $latestUsers = \App\Models\User::latest()->limit(5)->get(); @endphp
            @forelse($latestUsers as $user)
                <div class="flex items-center gap-3 py-3 @if(!$loop->last) border-b border-slate-100 @endif">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $user->email }}</p>
                    </div>
                    <x-ui.badge :color="$user->status->color()">{{ $user->status->label() }}</x-ui.badge>
                </div>
            @empty
                <x-ui.empty-state title="No users" description="Users will appear here once created." icon="users" />
            @endforelse
        </x-ui.card>
    </div>
</div>
