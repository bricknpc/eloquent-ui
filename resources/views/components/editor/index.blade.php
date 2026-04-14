@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\Enums\LabelPosition;
@endphp

@props([
    'name',
    'value' => null,
    'label' => null,
    'labelId' => null,
    'form' => null,
    'required' => false,
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
        <div data-{{ ns() }}-blocknote-editor data-value="{{ old($name, $value ?? $modelValue) }}" {{ $attributes }}>
            <input
                type="hidden"
                name="{{ $name }}"
                value="{{ old($name, $value ?? $modelValue) }}"
                @if($form !== null) form="{{ $form }}" @endif
            />
        </div>
    </x-eloquent-ui::form.row>
@else
    <div data-{{ ns() }}-blocknote-editor data-value="{{ old($name, $value ?? $modelValue) }}" {{ $attributes }}>
        <input
            type="hidden"
            name="{{ $name }}"
            value="{{ old($name, $value ?? $modelValue) }}"
            @if($form !== null) form="{{ $form }}" @endif
        />
    </div>
@endif