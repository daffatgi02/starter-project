@props([
    'label' => null,
    'id',
    'rows' => 3,
    'required' => false,
    'error' => null,
])

<div>
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <textarea
        id="{{ $id }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => $error ? 'form-input-error' : 'form-input']) }}
        @required($required)
    >{{ $slot }}</textarea>
    @if($error)
        <x-form.error :message="$error" />
    @endif
</div>
