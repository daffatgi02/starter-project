{{-- Sidebar --}}
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out lg:translate-x-0"
>
    <div class="flex h-full flex-col">
        {{-- Logo --}}
        <div class="flex h-16 items-center gap-2 px-6 border-b border-slate-200">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600 text-white font-bold text-sm">
                S
            </div>
            <span class="text-lg font-bold text-slate-900">{{ config('app.name', 'Starter') }}</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('dashboard')])>
                <x-ui.icon name="squares-2x2" size="sm" />
                <span>Dashboard</span>
            </a>

            @can('view users')
            <a href="{{ route('users.index') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('users.*')])>
                <x-ui.icon name="users" size="sm" />
                <span>Users</span>
            </a>
            @endcan

            @can('view roles')
            <a href="{{ route('roles.index') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('roles.*')])>
                <x-ui.icon name="shield-check" size="sm" />
                <span>Roles & Permissions</span>
            </a>
            @endcan

            @can('view settings')
            <a href="{{ route('settings.index') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('settings.*')])>
                <x-ui.icon name="cog-6-tooth" size="sm" />
                <span>Settings</span>
            </a>
            @endcan

            @can('view activity-logs')
            <a href="{{ route('activity-logs.index') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('activity-logs.*')])>
                <x-ui.icon name="clipboard-document-list" size="sm" />
                <span>Activity Logs</span>
            </a>
            @endcan
        </nav>

        {{-- User section --}}
        <div class="border-t border-slate-200 px-4 py-4">
            <a href="{{ route('profile.edit') }}"
               @class(['sidebar-link', 'active' => request()->routeIs('profile.*')])>
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-700 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->roles->first()?->name ?? 'user' }}</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-600 hover:bg-red-50 hover:text-red-700">
                    <x-ui.icon name="arrow-right-on-rectangle" size="sm" />
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
