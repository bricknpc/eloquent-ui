@props([
    'href',
])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'card-link']) }}>{{ $slot }}</a>