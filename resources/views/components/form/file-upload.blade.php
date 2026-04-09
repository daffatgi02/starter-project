@props([
    'label' => null,
    'id',
    'accept' => null,
    'multiple' => false,
    'error' => null,
])

<div x-data="{ filename: '' }">
    @if($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <div class="flex items-center gap-3">
        <label
            for="{{ $id }}"
            class="btn-secondary cursor-pointer"
        >
            <x-ui.icon name="arrow-up-tray" size="sm" />
            <span>Choose file</span>
        </label>
        <span x-text="filename || 'No file chosen'" class="text-sm text-slate-500 truncate"></span>
    </div>
    <input
        type="file"
        id="{{ $id }}"
        class="sr-only"
        @if($accept) accept="{{ $accept }}" @endif
        @if($multiple) multiple @endif
        @change="filename = $event.target.files.length > 1
            ? $event.target.files.length + ' files selected'
            : $event.target.files[0]?.name || ''"
        {{ $attributes }}
    />
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
