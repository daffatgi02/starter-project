@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'icon' => null,
])

@php
    $classes = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-5 py-2.5 text-base',
        default => '',
    };
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$classes} {$sizeClasses}"]) }}>
        @if($icon)
            <x-ui.icon :name="$icon" size="sm" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$classes} {$sizeClasses}", 'disabled' => $disabled]) }}>
        @if($icon)
            <x-ui.icon :name="$icon" size="sm" />
        @endif
        {{ $slot }}
    </button>
@endif
