@props([
    'name',
    'style' => 'outline',
    'size' => 'md',
])

@php
    $sizeClass = match($size) {
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5',
    };

    $prefix = $style === 'solid' ? 'heroicon-s' : 'heroicon-o';
    $component = "{$prefix}-{$name}";
@endphp

<x-dynamic-component :component="$component" {{ $attributes->merge(['class' => $sizeClass]) }} />
