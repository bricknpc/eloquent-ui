@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;

    /** @var LabelPosition $labelPosition */
@endphp
@props([
    'name',
    'label'          => null,
    'form'           => null,
    'value'          => null,
    'currencies'     => [],
    'currency'       => null,
    'required'       => false,
    'placeholder'    => null,
    'min'            => null,
    'max'            => null,
    'autofocus'      => false,
    'tabindex'       => null,
    'label-position' => config('eloquent-ui.input.position', LabelPosition::Left),
    'hint'           => null,
    'button-style'   => config('eloquent-ui.input.button-style', 'outline-secondary'),
    'required-style' => config('eloquent-ui.input.required-style', 'danger'),
    'addon-style'    => config('eloquent-ui.input.addon-style', 'secondary'),
    'focus-switch'   => config('eloquent-ui.input.currency.focus-switch', true),
])
<div {{ $attributes->merge(['class' => 'row']) }}>
    <label
        for="{{ $name }}-whole"
        id="{{ $name }}-label"
        class="col-form-label {{ $labelPosition->getLabelClasses() }}"
    >
        {{ $label ?? str($name)->title() }}
        @if($required)
            <span
                class="text-{{ $requiredStyle }}"
                aria-hidden="true"
            >{{ config('eloquent-ui.input.required-icon', '*') }}</span>
            <span class="visually-hidden">{{ __('required') }}</span>
        @endif
    </label>
    <div class="{{ $labelPosition->getInputClasses() }}">
        <x-eloquent-ui::input.currency
            :name="$name"
            :labelId="$name . '-label'"
            :value="$value"
            :currencies="$currencies"
            :currency="$currencies"
            :required="$required"
            :placeholder="$placeholder"
            :min="$min"
            :max="$max"
            :autofocus="$autofocus"
            :tabindex="$tabindex"
            :hint="$hint"
            :button-style="$buttonStyle"
            :addon-style="$addonStyle"
            :focus-switch="$focusSwitch"
        />
    </div>
</div>