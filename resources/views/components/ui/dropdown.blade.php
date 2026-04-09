<div x-data="{ open: false }" class="relative" {{ $attributes }}>
    <div @click="open = !open" @keydown.escape.window="open = false">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.outside="open = false"
        class="absolute right-0 z-30 mt-2 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-slate-900/5 focus:outline-none"
        x-cloak
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
