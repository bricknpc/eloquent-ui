@php
    use function BrickNPC\EloquentUI\ns;
@endphp

@props([
    'name',
    'type' => 'button',
    'theme' => 'primary',
    'noWrap' => false,
    'disabled' => false,
    'readonly' => false,
    'toggle' => false,
    'pressed' => false,
    'offset' => null,
    'once' => false,
])
@if($offset !== null)
    <div class="row">
        <div class="offset-sm-{{ $offset }}">
@endif
<button
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $name }}"
    @if($disabled) disabled aria-disabled="true" @endif
    @if($readonly) readonly aria-readonly="true" @endif
    @if($toggle)
        data-bs-toggle="button"
        @if($pressed)
            aria-pressed="true"
        @endif
    @endif
    @if($once)
        data-{{ ns() }}-once="true"
    @endif
    {{ $attributes->class(['btn', 'btn-' . $theme, 'text-nowrap' => $noWrap, 'active' => $toggle && $pressed]) }}
>{{ $slot }}</button>
@if($offset !== null)
        </div>
    </div>
@endif