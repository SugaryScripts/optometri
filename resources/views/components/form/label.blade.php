@props(['value', 'required' => false])
<!-- No surplus words or unnecessary actions. - Marcus Aurelius -->

<label {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
