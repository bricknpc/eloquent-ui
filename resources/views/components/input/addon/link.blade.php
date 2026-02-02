@props([
    'id',
    'href',
    'style' => config('eloquent-ui.input.addon-button-style', 'secondary'),
])
<a
    id="{{ $id }}"
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'input-group-text btn btn-' . $style]) }}
>{{ $slot }}</a>