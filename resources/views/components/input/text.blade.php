@php
    use Illuminate\Database\Eloquent\Model;
    use BrickNPC\EloquentUI\Enums\LabelPosition;

    /** @var Model $model */
@endphp

@props([
    'name',
    'label'      => null,
    'value'      => null,
    'type'       => 'text',
    'labelId'    => null,
    'prefix'     => null,
    'suffix'     => null,
    'required'   => false,
    'disabled'   => false,
    'readonly'   => false,
    'hint'       => null,
    'valueUsing' => null,
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
    $modelValue = is_callable($valueUsing) ? call_user_func($valueUsing, $model, $attributes) : $model?->$name;

    if ($labelPosition !== null && !$labelPosition instanceof LabelPosition) {
        $labelPosition = LabelPosition::tryFrom($labelPosition);
    }
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
    </x-eloquent-ui::form.row>
@else
    @include('eloquent-ui::components.input.partials._text')
@endif
