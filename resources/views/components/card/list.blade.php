@php
    use Illuminate\View\Component;

    /** @var Component|null $header */
    /** @var Component|null $footer */
@endphp
@props([
    'header' => null,
    'footer' => null,
])
<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($header !== null)
        <div {{ $header->attributes->merge(['class' => 'card-header']) }}>{{ $header }}</div>
    @endif
    <ul class="list-group list-group-flush">
        {{ $slot }}
    </ul>
    @if($footer !== null)
        <div {{ $header->attributes->merge(['class' => 'card-header']) }}>{{ $header }}</div>
    @endif
</div>