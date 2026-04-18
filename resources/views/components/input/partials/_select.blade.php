@php
    use function BrickNPC\EloquentUI\ns;
@endphp

@props([
    'name',
    'value' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'labelId' => null,
    'multiple' => false,
    'allowCreate' => false,
    'options' => [],
    'prefix' => null,
    'suffix' => null,
    'hint' => null,
])

<div
        class="input-group has-validation"
        role="group"
>
    @if($prefix)
        {!! $prefix !!}
    @endif
    <div
        data-{{ ns() }}-dropdown="true"
        data-{{ ns() }}-name="{{ $name }}"
        data-{{ ns() }}-value="{{ json_encode($value) }}"
        data-{{ ns() }}-multiple="{{ $multiple ? 'true' : 'false' }}"
        data-{{ ns() }}-allow-create="{{ $allowCreate ? 'true' : 'false' }}"
        id="{{ $name }}"
        @if($required) aria-required="true" data-{{ ns() }}-required="true" @endif
        @if($disabled) aria-disabled="true" data-{{ ns() }}-disabled="true" @endif
        @if($readonly) aria-readonly="true" data-{{ ns() }}-readonly="true" @endif
        @if($labelId) aria-labelledby="{{ $labelId }}" @endif
        @error($name) aria-invalid="true" @enderror
        class="w-100 position-relative"
    >
        <div
            data-{{ ns() }}-input-select="true"
            @error($name) aria-invalid="true" @enderror
            aria-describedby="@if($prefix) {{ $prefix->attributes->get('id') }} @endif @if($suffix) {{ $suffix->attributes->get('id') }} @endif @if($hint){{ $name }}-hint @endif @error($name){{ $name }}-feedback @enderror"
            {{ $attributes
               ->class(['eui-dropdown-control', 'd-flex', 'align-items-center', 'justify-content-between', 'form-control', 'is-invalid' => isset($errors) && $errors->has($name)])
               ->except(['labelPosition', 'label-position', 'requiredIcon', 'required-icon', 'requiredStyle', 'required-style', 'labelWidth', 'label-width', 'rowClass', 'row-class', 'model', 'confirm'])
           }}
        >
            <span class="eui-dropdown-values d-inline-flex flex-wrap align-items-center gap-1 flex-grow-1">
                @if($multiple || $allowCreate)
                    <span
                        class="eui-dropdown-input border-0 rounded-3 border-transparent p-0"
                        data-{{ ns() }}-input-element
                        contenteditable="true"
                        style="min-width: 2px; outline: none;"
                    ></span>
                @endif
            </span>
            <span
                class="eui-dropdown-toggle-btn"
                data-{{ ns() }}-dropdown-toggle
                data-{{ ns() }}-dropdown-down="˅"
                data-{{ ns() }}-dropdown-up="˄"
            >˅</span>
        </div>

        <div
            data-{{ ns() }}-dropdown-options="true"
            class="eui-dropdown-options border rounded-3 shadow-sm border-dark-subtle overflow-y-auto position-absolute bg-body w-100 d-none"
            style="z-index: 999; top: calc(100% + 4px); left: 0; max-height: 220px;"
        >
            @if($allowCreate)
                <div
                    data-{{ ns() }}-dropdown-create
                    class="eui-dropdown-create px-3 py-1 d-none fst-italic text-muted"
                >
                    Create "<span data-{{ ns() }}-create-label></span>"
                </div>
            @endif
            @foreach($options as $optionKey => $optionName)
                <div
                    data-{{ ns() }}-dropdown-option="true"
                    data-value="{{ $optionKey ?? $optionName }}"
                    data-label="{{ $optionName }}"
                    class="eui-dropdown-option px-3 py-1"
                >{{ $optionName }}</div>
            @endforeach
            <div
                data-{{ ns() }}-no-results
                class="eui-dropdown-no-results px-3 py-1 text-muted fst-italic d-none"
            >No results found</div>
        </div>

        @if($multiple)
            <div data-{{ ns() }}-dropdown-values>
                @if(is_array($value))
                    @foreach($value as $valueKey => $valueName)
                        <input type="hidden" name="{{ $name }}[]" value="{{ $valueKey ?? $valueName }}" />
                    @endforeach
                @endif
            </div>
        @else
            <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-{{ ns() }}-hidden-input />
        @endif
    </div>
    @if($suffix)
        {!! $suffix !!}
    @endif
</div>
@if($hint)
    <div id="{{ $name }}-hint" class="form-text">{{ $hint }}</div>
@endif
@error($name)
    <div id="{{ $name }}-feedback" class="invalid-feedback d-block" role="alert">{{ $message }}</div>
@enderror