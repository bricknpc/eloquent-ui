@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;

    /** @var LabelPosition $labelPosition */
@endphp
@props([
    'name',
    'label'          => null,
    'value'          => null,
    'required'       => false,
    'placeholder'    => null,
    'autofocus'      => false,
    'tabindex'       => null,
    'label-position' => config('eloquent-ui.input.position', LabelPosition::Left),
    'hint'           => null,
    'required-style' => config('eloquent-ui.input.required-style', 'danger'),
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
        <x-eloquent-ui::input.iban
                :name="$name"
                :labelId="$name . '-label'"
                :value="$value"
                :required="$required"
                :placeholder="$placeholder"
                :autofocus="$autofocus"
                :tabindex="$tabindex"
                :hint="$hint"
        />
    </div>
</div>