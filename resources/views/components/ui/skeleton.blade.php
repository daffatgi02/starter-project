@props([
    'lines' => 3,
    'type' => 'lines',
])

<div {{ $attributes->merge(['class' => 'animate-pulse']) }}>
    @if($type === 'lines')
        <div class="space-y-3">
            @for($i = 0; $i < $lines; $i++)
                <div class="h-4 bg-slate-200 rounded" @if($i === $lines - 1) style="width: 75%" @endif></div>
            @endfor
        </div>
    @elseif($type === 'table')
        <div class="space-y-3">
            <div class="h-10 bg-slate-200 rounded"></div>
            @for($i = 0; $i < $lines; $i++)
                <div class="h-12 bg-slate-100 rounded"></div>
            @endfor
        </div>
    @elseif($type === 'card')
        <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-3">
            <div class="h-4 bg-slate-200 rounded w-1/3"></div>
            <div class="h-8 bg-slate-200 rounded w-1/2"></div>
            <div class="h-4 bg-slate-100 rounded w-2/3"></div>
        </div>
    @endif
</div>
