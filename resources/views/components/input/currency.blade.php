@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\ValueObjects\Currency;
@endphp
@props([
    'name',
    'label'              => null,
    'labelId'            => null,
    'form'               => null,
    'value'              => null,
    'currencies'         => [],
    'currency'           => null,
    'required'           => false,
    'placeholder'        => null,
    'min'                => null,
    'max'                => null,
    'autofocus'          => false,
    'tabindex'           => null,
    'hint'               => null,
    'buttonStyle'        => config('eloquent-ui.input.button-style', 'outline-secondary'),
    'addonStyle'         => config('eloquent-ui.input.addon-style', 'secondary'),
    'focusSwitch'        => config('eloquent-ui.input.currency.focus-switch', true),
    'valueUsing'         => null,
    'currencyValueUsing' => null,
])

@aware([
    'labelPosition' => null,
    'requiredIcon'  => config('eloquent-ui.input.required-icon', '*'),
    'requiredStyle' => config('eloquent-ui.input.required-style', 'danger'),
    'labelWidth'    => config('eloquent-ui.input.label-width', 3),
    'rowClass'      => config('eloquent-ui.input.row-class', 'mb-3'),
    'model'         => null,
])

@php
    $modelValue = $value ?? (is_callable($valueUsing) ? call_user_func($valueUsing, $model, $attributes) : $model?->$name);

    $wholeValue = $modelValue?->whole;
    $centsValue = $modelValue?->cents;
    $currencyValue = $currency ?? (is_callable($currencyValueUsing) ? call_user_func($currencyValueUsing, $model, $attributes) : $modelValue?->currency);
@endphp

@if($label !== null)
    <x-eloquent-ui::form.row
        for="{{ $name }}-whole"
        id="{{ $labelId ?? $name . '-label' }}"
        :required="$required"
        :label="$label"
        :label-position="$labelPosition"
        :required-icon="$requiredIcon"
        :required-style="$requiredStyle"
        :label-width="$labelWidth"
    >
        @include('eloquent-ui::components.input.partials._currency')
    </x-eloquent-ui::form.row>
@else
    @include('eloquent-ui::components.input.partials._currency')
@endif
