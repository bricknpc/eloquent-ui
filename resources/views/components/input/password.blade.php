@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;
@endphp

@props([
    'name',
    'confirm'         => false,
    'allowTypeSwitch' => config('eloquent-ui.input.password.allow-type-switch', "true"),
    'switchIcon'      => config('eloquent-ui.input.password.switch-icon', '👁'),
    'label'           => null,
    'type'            => 'password',
    'labelId'         => null,
    'prefix'          => null,
    'suffix'          => null,
    'required'        => false,
    'disabled'        => false,
    'readonly'        => false,
    'hint'            => null,
])

@aware([
    'labelPosition' => null,
    'requiredIcon'  => config('eloquent-ui.input.required-icon', '*'),
    'requiredStyle' => config('eloquent-ui.input.required-style', 'danger'),
    'labelWidth'    => config('eloquent-ui.input.label-width', 3),
    'rowClass'      => config('eloquent-ui.input.row-class', 'mb-3'),
])

@php
    $modelValue = null;
    if ($labelPosition !== null && !$labelPosition instanceof LabelPosition) {
        $labelPosition = LabelPosition::tryFrom($labelPosition);
    }

    if ($confirm) {
        $allowTypeSwitch = false;
    }

    if ($allowTypeSwitch === true) {
        $allowTypeSwitch = "true";
    } elseif ($allowTypeSwitch === false) {
        $allowTypeSwitch = "false";
    }

    $switchIcon ??= config('eloquent-ui.input.password.switch-icon', '👁');

    $switchAttribute = 'data-' . ns() . '-password-allow-switch';
    $iconAttribute = 'data-' . ns() . '-password-switch-icon';

    $attributes[$switchAttribute] = $allowTypeSwitch;
    $attributes[$iconAttribute] = $switchIcon;
@endphp

@if($label !== null)
    <x-eloquent-ui::form.row
        for="{{ $name }}"
        id="{{ $name }}-label"
        :required="$required"
        :label="$label"
        :label-position="$labelPosition"
        :required-icon="$requiredIcon"
        :required-style="$requiredStyle"
        :label-width="$labelWidth"
        :row-class="$rowClass"
    >
        @include('eloquent-ui::components.input.partials._text')
        @if($confirm)
            @include('eloquent-ui::components.input.partials._text', ['name' => $name . '_confirmation'])
        @endif
    </x-eloquent-ui::form.row>
@else
    @include('eloquent-ui::components.input.partials._text')
    @if($confirm)
        @include('eloquent-ui::components.input.partials._text', ['name' => $name . '_confirmation'])
    @endif
@endif
