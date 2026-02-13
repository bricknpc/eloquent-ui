@props([
    'theme' => null,
])
@php
    $themeClass = '';
    if ($theme !== null) {
        $themeClass = ' text-bg-' . $theme;
    }
@endphp
<div {{ $attributes->merge(['class' => 'card' . $themeClass])->except(['theme']) }}>
    {{ $slot }}
</div>