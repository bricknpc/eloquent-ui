<textare
    name="{{ $name }}"
    id="{{ $name }}"
    @if($required) required aria-required="true" @endif
    @if($disabled) disabled aria-disabled="true" @endif
    @if($readonly) readonly aria-readonly="true" @endif
    @if($labelId) aria-labelledby="{{ $labelId }}" @endif
    @error($name) aria-invalid="true" @enderror
    aria-describedby="@if($hint){{ $name }}-hint @endif @error($name){{ $name }}-feedback @enderror"
    {{ $attributes
        ->class(['form-control', 'is-invalid' => isset($errors) && $errors->has($name)])
        ->except(['labelPosition', 'label-position', 'requiredIcon', 'required-icon', 'requiredStyle', 'required-style', 'labelWidth', 'label-width', 'rowClass', 'row-class', 'model'])
    }}
>{{ old($name, $value ?? $modelValue) }}</textare>
@if($hint)
    <div id="{{ $name }}-hint" class="form-text">{{ $hint }}</div>
@endif
@error($name)
    <div id="{{ $name }}-feedback" class="invalid-feedback d-block" role="alert">{{ $message }}</div>
@enderror