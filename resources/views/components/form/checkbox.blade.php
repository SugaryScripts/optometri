@props([
    'label' => '',
    'value' => '',
    'inline' => false,
    'checked' => false,
])

<!-- The only way to do great work is to love what you do. - Steve Jobs -->
@php
    $name = $attributes->whereStartsWith('wire:model')->first();
@endphp

<div {{ $attributes->merge(['class' => 'form-check ' . ($inline ? 'form-check-inline' : '')]) }}>

    <input
        class="form-check-input @error($name) is-invalid @enderror"
        type="checkbox"
        id="{{ $value }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes }}
    />

    <label class="form-check-label" for="{{ $value }}">
        {{ $label }}
    </label>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>
