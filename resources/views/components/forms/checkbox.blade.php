
@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'checkbox',
        'id' => $name,
        'name' => $name, 
        'value' => $name, // Default to 0 if no old value exists
        'class' => 'form-checkbox' // Add a default class for styling
    ];
@endphp

<div class="inline-flex items-center gap-x-2">
    <input {{ $attributes->merge($defaults) }} />
    <span class="pl-1">{{ $label }}</span>
</div>
