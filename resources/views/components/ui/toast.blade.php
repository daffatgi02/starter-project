@props(['type' => 'success', 'message' => ''])

@php
    $styles = match($type) {
        'success' => ['bg' => 'bg-green-50 border-green-200', 'icon' => 'check-circle', 'color' => 'text-green-600'],
        'error'   => ['bg' => 'bg-red-50 border-red-200', 'icon' => 'x-circle', 'color' => 'text-red-600'],
        'warning' => ['bg' => 'bg-yellow-50 border-yellow-200', 'icon' => 'exclamation-triangle', 'color' => 'text-yellow-600'],
        'info'    => ['bg' => 'bg-blue-50 border-blue-200', 'icon' => 'information-circle', 'color' => 'text-blue-600'],
        default   => ['bg' => 'bg-slate-50 border-slate-200', 'icon' => 'information-circle', 'color' => 'text-slate-600'],
    };
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-3 rounded-lg border px-4 py-3 {$styles['bg']}"]) }}>
    <x-ui.icon :name="$styles['icon']" size="sm" class="{{ $styles['color'] }}" />
    <p class="text-sm font-medium {{ $styles['color'] }}">{{ $message }}</p>
    {{ $slot }}
</div>
