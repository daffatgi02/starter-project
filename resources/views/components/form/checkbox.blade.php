@props([
    'label' => null,
    'id',
    'required' => false,
    'error' => null,
])

<div class="flex items-start gap-3">
    <input
        type="checkbox"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500']) }}
        @required($required)
    />
    @if($label)
        <label for="{{ $id }}" class="text-sm text-slate-700">{{ $label }}</label>
    @endif
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
