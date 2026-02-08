@props([
    'name',
    'noWrap' => false,
    'offset' => null,
    'theme' => 'primary',
    'another' => false,
    'anotherTheme' => 'outline-primary',
    'anotherLabel' => null,
    'reset' => false,
    'resetTheme' => 'danger',
    'resetLabel' => null,
])
@if($offset !== null)
    <div class="row">
        <div class="offset-sm-{{ $offset }}">
@endif
<button
    type="submit"
    name="{{ $name }}"
    id="{{ $name }}"
    {{ $attributes->class(['btn', 'btn-' . $theme, 'text-nowrap' => $noWrap]) }}
>{{ $slot }}</button>
@if($another)
    <button
        type="submit"
        name="add-another"
        id="{{ $name }}-add-another"
        {{ $attributes->class(['btn', 'btn-' . $anotherTheme, 'text-nowrap' => $noWrap]) }}
    >{{ $anotherLabel ?? $slot . __(' and add another') }}</button>
@endif
@if($another)
    <button
        type="reset"
        name="{{ $name }}-reset"
        id="{{ $name }}-reset"
        {{ $attributes->class(['btn', 'btn-' . $resetTheme, 'text-nowrap' => $noWrap]) }}
    >{{ $resetLabel ?? __('Reset') }}</button>
@endif
@if($offset !== null)
        </div>
    </div>
@endif