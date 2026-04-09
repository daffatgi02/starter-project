@props([
    'label' => null,
    'id',
    'options' => [],
    'required' => false,
    'error' => null,
    'placeholder' => 'Select an option',
])

<div>
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <select
        id="{{ $id }}"
        {{ $attributes->merge(['class' => $error ? 'form-input-error' : 'form-input']) }}
        @required($required)
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
