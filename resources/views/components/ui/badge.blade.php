@props([
    'color' => 'gray',
    'size' => 'sm',
    'icon' => null,
])

@php
    $colorClass = "badge-{$color}";
    $sizeClass = $size === 'md' ? 'px-2.5 py-1 text-sm' : '';
@endphp

<span {{ $attributes->merge(['class' => "{$colorClass} {$sizeClass}"]) }}>
    @if($icon)
        <x-ui.icon :name="$icon" size="xs" />
    @endif
    {{ $slot }}
</span>
