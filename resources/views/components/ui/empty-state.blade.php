@props([
    'title' => 'No data found',
    'description' => 'There are no records to display at this time.',
    'icon' => 'inbox',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 text-center']) }}>
    <div class="rounded-full bg-slate-100 p-4">
        <x-ui.icon :name="$icon" size="lg" class="text-slate-400" />
    </div>
    <h3 class="mt-4 text-sm font-semibold text-slate-900">{{ $title }}</h3>
    <p class="mt-1 text-sm text-slate-500 max-w-sm">{{ $description }}</p>
    @isset($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @endisset
</div>
