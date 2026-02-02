@props([
    'id',
    'style' => config('eloquent-ui.input.addon-button-style', 'secondary'),
])
<button
    type="button"
    role="button"
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'input-group-text btn btn-' . $style]) }}
>{{ $slot }}</button>