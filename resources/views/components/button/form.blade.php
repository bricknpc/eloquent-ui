@php
    use function BrickNPC\EloquentUI\ns;
@endphp

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
    'once' => false,
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
    @if($once)
        data-{{ ns() }}-once="true"
        data-{{ ns() }}-once-others="#{{ $name }}-submit-another"
    @endif
>{{ $slot }}</button>
@if($another)
    <button
        type="submit"
        name="submit-another"
        id="{{ $name }}-submit-another"
        {{ $attributes->class(['btn', 'btn-' . $anotherTheme, 'text-nowrap' => $noWrap]) }}
        @if($once)
            data-{{ ns() }}-once="true"
            data-{{ ns() }}-once-others="#{{ $name }}-submit"
        @endif
    >{{ $anotherLabel ?? __(':slot and add another', ['slot' => $slot]) }}</button>
@endif
@if($reset)
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