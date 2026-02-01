@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;

    /** @var LabelPosition $labelPosition */
@endphp
@props([
    'name',
    'label-id'       => null,
    'value'          => null,
    'required'       => false,
    'placeholder'    => null,
    'autofocus'      => false,
    'tabindex'       => null,
    'hint'           => null,
])
<div
        {{ $attributes->merge(['class' => 'input-group has-validation']) }}
        role="group"
        @if($labelId)
            aria-labelledby="{{ $labelId }}"
        @endif
        data-{{ ns() }}-input="iban"
        data-{{ ns() }}-name="{{ $name }}"
        @if($required) data-{{ ns() }}-required="true" @endif
>
    Component
</div>