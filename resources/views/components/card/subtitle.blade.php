@props([
    'level' => '5',
])
<h{{ $level }} {{ $attributes->merge(['class' => 'card-subtitle']) }}>{{ $slot }}</h{{ $level }}>