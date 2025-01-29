@props([
    'value',
    'required' => false,
    'inline' => false,
    ])
<!-- No surplus words or unnecessary actions. - Marcus Aurelius -->

<label {{ $attributes->merge(['class' => ($inline ? 'form-label' : 'col-form-label')]) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
