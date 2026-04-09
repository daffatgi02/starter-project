@props([
    'field',
    'sortField',
    'sortDirection',
])

<button
    type="button"
    wire:click="sortBy('{{ $field }}')"
    class="group inline-flex items-center gap-1 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 hover:text-slate-700"
>
    {{ $slot }}
    <span class="flex flex-col">
        @if($sortField === $field)
            @if($sortDirection === 'asc')
                <x-ui.icon name="chevron-up" size="xs" style="solid" class="text-primary-600" />
            @else
                <x-ui.icon name="chevron-down" size="xs" style="solid" class="text-primary-600" />
            @endif
        @else
            <x-ui.icon name="chevron-up-down" size="xs" class="text-slate-300 group-hover:text-slate-400" />
        @endif
    </span>
</button>
