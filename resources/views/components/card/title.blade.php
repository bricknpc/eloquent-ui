@props([
    'level' => '3',
])
<h{{ $level }} {{ $attributes->merge(['class' => 'card-title']) }}>{{ $slot }}</h{{ $level }}>