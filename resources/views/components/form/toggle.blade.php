@props([
    'label' => null,
    'id',
    'error' => null,
])

<div class="flex items-center justify-between">
    @if($label)
        <label for="{{ $id }}" class="text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif
    <button
        type="button"
        id="{{ $id }}"
        x-data="{ enabled: false }"
        x-init="enabled = $wire.get('{{ $attributes->wire('model')->value() }}')"
        @click="enabled = !enabled; $wire.set('{{ $attributes->wire('model')->value() }}', enabled)"
        :class="enabled ? 'bg-primary-600' : 'bg-slate-200'"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
    >
        <span
            :class="enabled ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        ></span>
    </button>
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
