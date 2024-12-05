@props([
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'disabled' => false,
])
<!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->

@php
    $idName = $name ?? $attributes->whereStartsWith('wire:model')->first();
@endphp

<input
    id="{{ $idName }}"
    type="{{ $type }}"
    placeholder="{{ $placeholder }}"
    name="{{ $idName }}"
    {{ $attributes->merge([
        'class' => 'form-control' . ($errors->has($attributes->whereStartsWith('wire:model')->first()) ? ' is-invalid' : ''),
        'disabled' => $disabled ? 'disabled' : null,
        'wire:loading.class' => $disabled ? null : 'border-warning',
    ]) }}
>

<div class="invalid-feedback">
    @error($attributes->whereStartsWith('wire:model')->first())
    {{ $message }}
    @enderror
</div>
