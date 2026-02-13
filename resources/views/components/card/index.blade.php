@props([
    'title' => null,
    'header' => null,
    'footer' => null,
    'bodyClass' => null,
    'titleClass' => null,
    'titleSize' => '3',
    'theme' => null,
])
@php
    use Illuminate\View\Component;

    /** @var Component|null $header */
    /** @var Component|null $footer */

    $themeClass = '';
    if ($theme !== null) {
        $themeClass = ' text-bg-' . $theme;
    }
@endphp
<div {{ $attributes->merge(['class' => 'card' . $themeClass])->except(['title', 'header', 'footer', 'bodyClass', 'body-class', 'titleClass', 'title-class', 'titleSize', 'title-size', 'theme']) }}>
    @if($header !== null)
        <div {{ $header->attributes->merge(['class' => 'card-header']) }}>{{ $header }}</div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        @if($title !== null)
            <h{{ $titleSize }} class="card-title {{ $titleClass }}">{{ $title }}</h{{ $titleSize }}>
        @endif
        {{ $slot }}
    </div>

    @if($footer !== null)
        <div {{ $header->attributes->merge(['class' => 'card-header']) }}>{{ $header }}</div>
    @endif
</div>