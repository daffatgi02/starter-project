<div class="relative max-w-md" x-data="{ open: false }" @click.outside="open = false">
    <div class="relative">
        <x-ui.icon name="magnifying-glass" size="sm" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
        <input
            wire:model.live.debounce.300ms="query"
            @focus="open = true"
            type="text"
            placeholder="Search users..."
            class="form-input pl-10 w-full bg-slate-50 border-slate-200 focus:bg-white"
        />
        @if($query)
            <button wire:click="clear" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                <x-ui.icon name="x-mark" size="xs" />
            </button>
        @endif
    </div>

    @if(!empty($results) && $query)
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="absolute mt-2 w-full rounded-lg bg-white shadow-lg ring-1 ring-slate-900/5 z-50 overflow-hidden"
        >
            @foreach($results as $result)
                <a
                    href="{{ $result['url'] }}"
                    class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors"
                    @click="open = false"
                >
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($result['name'], 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ $result['name'] }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $result['email'] }}</p>
                    </div>
                    <x-ui.badge color="blue" size="sm">{{ $result['type'] }}</x-ui.badge>
                </a>
            @endforeach
        </div>
    @elseif(strlen($query) >= 2 && empty($results))
        <div
            x-show="open"
            class="absolute mt-2 w-full rounded-lg bg-white shadow-lg ring-1 ring-slate-900/5 z-50 p-4 text-center"
        >
            <x-ui.icon name="magnifying-glass" size="md" class="mx-auto text-slate-300" />
            <p class="mt-2 text-sm text-slate-500">No results found</p>
        </div>
    @endif
</div>
