@props([
    'src',
    'location' => 'top',
    'alt' => null,
])
<img
    src="{{ $src }}"
    {{ $attributes->merge(['class' => 'card-img-' . $location]) }}
    @if($alt !== null) alt="{{ $alt }}" @endif
/>
