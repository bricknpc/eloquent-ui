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
    'labelWidth'    => config('eloquent-ui.input.label-width', 3),
])

@aware([
    'rowClass' => config('eloquent-ui.input.row-class', 'mb-3'),
])

<div {{ $attributes->merge(['class' => 'row ' . $rowClass]) }}>
    <label
        for="{{ $for }}"
        id="{{ $id ?? $for . '-label' }}"
        class="col-form-label {{ $labelPosition->getLabelClasses($labelWidth) }}"
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
    <div class="{{ $labelPosition->getInputClasses($labelWidth) }}">
        {{ $slot }}
    </div>
</div>
