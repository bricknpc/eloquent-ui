@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\Position;

    /** @var Position $labelPosition */
@endphp
@props([
    'name',
    'label'          => null,
    'value'          => null,
    'currencies'     => [],
    'currency'       => null,
    'required'       => false,
    'placeholder'    => null,
    'min'            => null,
    'max'            => null,
    'autofocus'      => false,
    'tabindex'       => null,
    'label-position' => config('eloquent-ui.input.position', Position::Left),
    'hint'           => null,
    'button-style'   => config('eloquent-ui.input.button-style', 'outline-secondary'),
    'required-style' => config('eloquent-ui.input.required-style', 'danger'),
    'addon-style'    => config('eloquent-ui.input.addon-style', 'secondary'),
])
<div {{ $attributes->merge(['class' => 'row mb-3']) }}>
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
        <div
            class="input-group has-validation"
            role="group"
            aria-labelledby="{{ $name }}-label"
            data-{{ ns() }}-input="currency"
            @if($required) data-{{ ns() }}-input-required="true" @endif
            @if($min !== null) data-{{ ns() }}-input-min="{{ $min }}" @endif
            @if($max !== null) data-{{ ns() }}-input-max="{{ $max }}" @endif
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
                <div aria-live="polite" aria-atomic="true" class="visually-hidden" data-{{ ns() }}-currency-announcement="true"></div>
            @elseif($currency !== null)
                <span
                    class="input-group-text bg-{{ $addonStyle }}"
                    id="{{ $name }}-addon"
                    @if($tabindex !== null) tabindex="{{ $tabindex }}" @endif
                >{{ $currency }}</span>
            @endif
            <input type="hidden" name="{{ $name }}-currency" id="{{ $name }}-currency" value="{{ $currency }}" />
            <input
                type="number"
                step="1"
                name="{{ $name }}-whole"
                id="{{ $name }}-whole"
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
    </div>
</div>