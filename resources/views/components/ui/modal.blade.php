@props([
    'title' => 'Confirm',
    'maxWidth' => 'md',
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        default => 'sm:max-w-md',
    };
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')).live }"
    x-show="show"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    x-cloak
>
    <div class="flex min-h-full items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="show = false"></div>

        {{-- Modal content --}}
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full {{ $maxWidthClass }} transform rounded-xl bg-white shadow-xl transition-all"
        >
            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-200">
                @isset($headerIcon)
                    {{ $headerIcon }}
                @endisset
                <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
                <button @click="show = false" type="button" class="ml-auto text-slate-400 hover:text-slate-600">
                    <x-ui.icon name="x-mark" size="sm" />
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @isset($footer)
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
