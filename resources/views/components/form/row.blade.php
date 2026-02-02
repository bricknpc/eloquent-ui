@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;

    /** @var LabelPosition $labelPosition */
@endphp
@props([
    'for',
    'id'            => null,
    'label'         => null,
    'required'      => false,
    'labelPosition' => config('eloquent-ui.input.position', LabelPosition::Left),
    'requiredIcon'  => config('eloquent-ui.input.required-icon', '*'),
    'requiredStyle' => config('eloquent-ui.input.required-style', 'danger'),
])
<div {{ $attributes->merge(['class' => 'row']) }}>
    <label
        for="{{ $for }}"
        id="{{ $id ?? $for . '-label' }}"
        class="col-form-label {{ $labelPosition->getLabelClasses() }}"
    >
        {{ $label ?? str($for)->title() }}
        @if($required)
            <span
                class="text-{{ $requiredStyle }}"
                aria-hidden="true"
            >{{ $requiredIcon }}</span>
            <span class="visually-hidden">{{ __('required') }}</span>
        @endif
    </label>
    <div class="{{ $labelPosition->getInputClasses() }}">
        {{ $slot }}
    </div>
</div>