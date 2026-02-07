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

@if($label)
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
@endif
<div
        {{ $attributes->merge(['class' => 'input-group has-validation']) }}
        role="group"
        aria-labelledby="{{ $labelId ?? $name . '-label' }}"
        data-{{ ns() }}-input="currency"
        data-{{ ns() }}-name="{{ $name }}"
        data-{{ ns() }}-focus-switch="{{ $focusSwitch }}"
        @if($required) data-{{ ns() }}-required="true" @endif
        @if($min !== null) data-{{ ns() }}-min="{{ $min }}" @endif
        @if($max !== null) data-{{ ns() }}-max="{{ $max }}" @endif
>
@if(count($currencies) > 0)
    <button
        class="btn btn-{{ $buttonStyle }} dropdown-toggle border-end-1 border-light"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        aria-label="{{ __('Select currency') }}"
        @if($tabindex !== null) tabindex="{{ $tabindex }}" @endif
        data-{{ ns() }}-currency-select="true"
        data-{{ ns() }}-currency-symbol="{{ config('eloquent-ui.input.currency.generic-symbol', '¤') }}"
    >
        {{ $currencyValue ?? config('eloquent-ui.input.currency.generic-symbol', '¤') }}
    </button>
    <ul class="dropdown-menu">
        @foreach($currencies as $key => $nameOrSymbol)
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    data-{{ ns() }}-value="{{ $key }}"
                    @if($key === $currencyValue) aria-current="true" @endif
                >{{ $nameOrSymbol }}</button>
            </li>
        @endforeach
    </ul>
@elseif($currencyValue !== null)
    <span
        class="input-group-text bg-{{ $addonStyle }}"
        id="{{ $name }}-addon"
        @if($tabindex !== null) tabindex="{{ $tabindex }}" @endif
    >{{ $currencyValue }}</span>
@endif
    <input
        type="number"
        step="1"
        name="{{ $name }}-whole"
        id="{{ $name }}-whole"
        @if($form) form="{{ $form }}" @endif
        @if($autofocus) autofocus @endif
        @if($tabindex !== null) tabindex="{{ count($currencies) > 0 || $currency !== null ? $tabindex + 1 : $tabindex }}" @endif
        @if($required) aria-required="true" required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        aria-describedby="@if($currency !== null && count($currencies) === 0){{ $name }}-currency-addon @endif @if($hint){{ $name }}-hint @endif @error($name){{ $name }}-feedback @enderror"
        @error($name) aria-invalid="true" @enderror
        class="form-control text-end @error($name) is-invalid @enderror"
        value="{{ old($name . '-whole', $wholeValue) }}"
    />
    <span class="input-group-text bg-transparent border-0 p-1" aria-hidden="true">{{ config('eloquent-ui.decimal-separator', ',') }}</span> {{-- todo: Let locale decide this in the future, not the config --}}
    <input
        type="number"
        step="1"
        min="0"
        max="99"
        name="{{ $name }}-cents"
        id="{{ $name }}-cents"
        aria-label="{{ __('Cents') }}"
        @if($form) form="{{ $form }}" @endif
        @if($tabindex !== null) tabindex="{{ count($currencies) > 0 || $currency !== null ? $tabindex + 2 : $tabindex + 1 }}" @endif
        aria-describedby="@if($currency !== null && count($currencies) === 0){{ $name }}-currency-addon @endif @if($hint){{ $name }}-hint @endif @error($name){{ $name }}-feedback @enderror"
        @error($name) aria-invalid="true" @enderror
        @if($required) aria-required="true" required @endif
        class="form-control text-end @error($name) is-invalid @enderror"
        value="{{ old($name . '-cents', $centsValue) }}"
        style="max-width: 20%"
    />
</div>
<input
    type="hidden"
    name="{{ $name }}-currency"
    id="{{ $name }}-currency"
    value="{{ $currency }}"
    @if($form) form="{{ $form }}" @endif
/>
<div
    aria-live="polite"
    aria-atomic="true"
    class="visually-hidden"
    data-{{ ns() }}-currency-announcement="true"
    data-{{ ns() }}-currency-announcement-message="{{ __('Currency of :attribute has been changed to :key (:value)') }}"
></div>
@if($hint)
    <div id="{{ $name }}-hint" class="form-text">{{ $hint }}</div>
@endif
@error($name)
    <div id="{{ $name }}-feedback" class="invalid-feedback d-block" role="alert">{{ $message }}</div>
@enderror
@if($label)
    </x-eloquent-ui::form.row>
@endif
