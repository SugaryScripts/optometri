@props([
    'for'
    ])
<!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
@error($for)
<p {{ $attributes->merge(['class' => 'text-sm text-danger']) }}>{{ $message }}</p>
@enderror
