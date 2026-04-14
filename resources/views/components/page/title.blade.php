@props(['level' => 1])
<h{{ $level }} {{ $attributes->merge(['class' => 'border-bottom border-primary-subtle']) }}>{{ $slot }}</h{{ $level }}>
