@props(['title'])
@aware(['component'])
@php
    use BrickNPC\EloquentUI\Http\Views\Components\Card\Tabs;
    /** @var Tabs $component */

    if (!$component instanceof Tabs) {
        throw new Exception('The card.tab component can only be used inside a card.tabs component.');
    }

    $id = $component->registerTab($title);
@endphp

<div
    id="{{ $id }}"
    role="tabpanel"
    {{ $attributes->merge(['class' => 'tab-pane fade'])->except(['id', 'role']) }}
>
    {{ $slot }}
</div>
