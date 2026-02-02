@props([
    'id',
    'style' => config('eloquent-ui.input.addon-style', 'secondary'),
])
<span
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'input-group-text bg-' . $style]) }}
>{{ $slot }}</span>