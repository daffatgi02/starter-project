@props([
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
])

<div {{ $attributes }}>
    {{ $slot }}
</div>
