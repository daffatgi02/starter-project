@props([
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200 shadow-sm']) }}>
    @isset($header)
        <div class="px-6 py-4 border-b border-slate-200">
            {{ $header }}
        </div>
    @endisset

    <div @class(['px-6 py-4' => $padding])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
            {{ $footer }}
        </div>
    @endisset
</div>
