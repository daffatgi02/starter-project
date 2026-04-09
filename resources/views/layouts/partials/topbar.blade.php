<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200 bg-white/95 backdrop-blur px-6">
    {{-- Mobile menu button --}}
    <button
        @click="sidebarOpen = !sidebarOpen"
        type="button"
        class="lg:hidden -ml-2 rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
    >
        <x-ui.icon name="bars-3" size="md" />
    </button>

    {{-- Search --}}
    <div class="flex-1">
        <livewire:components.global-search />
    </div>

    {{-- Right side --}}
    <div class="flex items-center gap-3">
        {{-- Notifications placeholder --}}
        <button type="button" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
            <x-ui.icon name="bell" size="sm" />
        </button>

        {{-- User dropdown --}}
        <x-ui.dropdown>
            <x-slot:trigger>
                <button type="button" class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-slate-100">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <x-ui.icon name="chevron-down" size="xs" class="text-slate-400" />
                </button>
            </x-slot:trigger>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                <x-ui.icon name="user" size="sm" class="text-slate-400" />
                Profile
            </a>
            @can('view settings')
            <a href="{{ route('settings.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                <x-ui.icon name="cog-6-tooth" size="sm" class="text-slate-400" />
                Settings
            </a>
            @endcan
            <div class="border-t border-slate-100 my-1"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <x-ui.icon name="arrow-right-on-rectangle" size="sm" />
                    Logout
                </button>
            </form>
        </x-ui.dropdown>
    </div>
</header>
