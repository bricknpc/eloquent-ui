@php
    use function BrickNPC\EloquentUI\ns;
@endphp
@props([
    'name',
    'label-id'       => null,
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
    'hint'           => null,
    'button-style'   => config('eloquent-ui.input.button-style', 'outline-secondary'),
    'addon-style'    => config('eloquent-ui.input.addon-style', 'secondary'),
    'focus-switch'   => config('eloquent-ui.input.currency.focus-switch', true),
])
<div
    {{ $attributes->merge(['class' => 'input-group has-validation']) }}
    role="group"
    @if($labelId)
        aria-labelledby="{{ $labelId }}"
    @endif
    data-{{ ns() }}-input="currency"
    data-{{ ns() }}-name="{{ $name }}"
    data-{{ ns() }}-focus-switch="{{ $focusSwitch }}"
    @if($required) data-{{ ns() }}-required="true" @endif
    @if($min !== null) data-{{ ns() }}-min="{{ $min }}" @endif
    @if($max !== null) data-{{ ns() }}-max="{{ $max }}" @endif
>
    @if(count($currencies) > 0)
        <div
            class="dropdown"
            data-{{ ns() }}-currency-select="true"
            data-{{ ns() }}-currency-symbol="{{ config('eloquent-ui.input.currency.generic-symbol', '¤') }}"
        >
            <button
                class="btn btn-{{ $buttonStyle }} dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                aria-label="{{ __('Select currency') }}"
                @if($tabindex !== null) tabindex="{{ $tabindex }}" @endif
            >
                {{ $currency ?? config('eloquent-ui.input.currency.generic-symbol', '¤') }}
            </button>
            <ul class="dropdown-menu">
                @foreach($currencies as $key => $nameOrSymbol)
                    <li>
                        <button
                            type="button"
                            class="dropdown-item"
                            data-{{ ns() }}-value="{{ $key }}"
                            @if($key === $currency) aria-current="true" @endif
                        >{{ $nameOrSymbol }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div
            aria-live="polite"
            aria-atomic="true"
            class="visually-hidden"
            data-{{ ns() }}-currency-announcement="true"
            data-{{ ns() }}-currency-announcement-message="{{ __('Currency of :attribute has been changed to :key (:value)') }}"
        ></div>
    @elseif($currency !== null)
        <span
            class="input-group-text bg-{{ $addonStyle }}"
            id="{{ $name }}-addon"
            @if($tabindex !== null) tabindex="{{ $tabindex }}" @endif
        >{{ $currency }}</span>
    @endif
    <input
        type="hidden"
        name="{{ $name }}-currency"
        id="{{ $name }}-currency"
        value="{{ $currency }}"
        @if($form) form="{{ $form }}" @endif
    />
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
        value="{{ old($name . '-whole', $value !== null ? floor($value / 100) : '') }}"
    />
    <span class="input-group-text" aria-hidden="true">{{ config('eloquent-ui.decimal-separator', ',') }}</span> {{-- todo: Let locale decide this in the future, not the config --}}
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
        value="{{ old($name . '-cents', $value !== null ? $value % 100 : '') }}"
    />
</div>
@if($hint)
    <div id="{{ $name }}-hint" class="form-text">{{ $hint }}</div>
@endif
@error($name)
    <div id="{{ $name }}-feedback" class="invalid-feedback d-block" role="alert">{{ $message }}</div>
@enderror