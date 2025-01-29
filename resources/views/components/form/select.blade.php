@props([
    'label' => '',
    'name' => null,
    'placeholder' => 'Pilih pilihan',
    'disabled' => false,
    'required' => null,
    'inline' => false,
])
@php
    $idName = $name ?? $attributes->whereStartsWith('wire:model')->first();
@endphp

<label for="{{ $idName }}" class="{{ $inline ? 'form-label' : 'col-form-label' }}">
    {{ $label }}
    @if(isset($required))
        <span class="text-danger">*</span>
    @endif
</label>
<select id="{{ $idName }}"
        {{ $attributes->whereStartsWith('wire:') }}
        {{ $disabled ? 'disabled' : "wire:loading.class=border-warning" }}
        class="form-control form-select @error( $attributes->whereStartsWith('wire:model')->first() ) is-invalid @enderror">
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
</select>
<div class="invalid-feedback">
    @error( $attributes->whereStartsWith('wire:model')->first() ) {{ $message }} @enderror
</div>
{{--
wire:loading.attr="disabled"
wire:target="nama"--}}
