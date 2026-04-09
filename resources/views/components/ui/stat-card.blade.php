@props([
    'title',
    'value',
    'icon' => 'chart-bar',
    'change' => null,
    'changeType' => 'neutral',
    'color' => 'primary',
])

@php
    $iconBg = match($color) {
        'primary' => 'bg-primary-50 text-primary-600',
        'green' => 'bg-green-50 text-green-600',
        'red' => 'bg-red-50 text-red-600',
        'yellow' => 'bg-yellow-50 text-yellow-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'purple' => 'bg-purple-50 text-purple-600',
        default => 'bg-primary-50 text-primary-600',
    };

    $changeColor = match($changeType) {
        'increase' => 'text-green-600',
        'decrease' => 'text-red-600',
        default => 'text-slate-500',
    };

    $changeIcon = match($changeType) {
        'increase' => 'arrow-trending-up',
        'decrease' => 'arrow-trending-down',
        default => null,
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200 shadow-sm p-6']) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $value }}</p>
            @if($change)
                <div class="mt-1 flex items-center gap-1 {{ $changeColor }}">
                    @if($changeIcon)
                        <x-ui.icon :name="$changeIcon" size="xs" />
                    @endif
                    <span class="text-xs font-medium">{{ $change }}</span>
                </div>
            @endif
        </div>
        <div class="flex-shrink-0 rounded-lg p-3 {{ $iconBg }}">
            <x-ui.icon :name="$icon" size="md" />
        </div>
    </div>
</div>
