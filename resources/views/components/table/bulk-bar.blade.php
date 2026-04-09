@props(['selectedCount' => 0])

@if($selectedCount > 0)
    <div {{ $attributes->merge(['class' => 'flex items-center justify-between rounded-lg bg-primary-50 border border-primary-200 px-4 py-3']) }}>
        <div class="flex items-center gap-2">
            <x-ui.icon name="check-circle" size="sm" class="text-primary-600" />
            <span class="text-sm font-medium text-primary-700">{{ $selectedCount }} item(s) selected</span>
        </div>
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
@endif
