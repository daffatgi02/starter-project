@props([
    'label' => null,
    'id',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
])

<div>
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => $error ? 'form-input-error' : 'form-input']) }}
        @disabled($disabled)
        @required($required)
    />
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
