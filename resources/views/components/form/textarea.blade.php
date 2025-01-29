
@props([
    'required' => false,
    'name' => null,
])
<!-- He who is contented is rich. - Laozi -->
@php
    $name = $name ?? $attributes->whereStartsWith('wire:model')->first();
@endphp
<textarea
    {{ $attributes }}
    {{ $attributes->merge(['class'=>'form-control']) }}
    name="{{ $name }}"
    id="{{ $name }}">
</textarea>
