@php
use Illuminate\Database\Eloquent\Model;

/** @var Model $model */
@endphp

@props([
    'action',
    'method'    => 'post',
    'files'     => false,
    'name'      => null,
    'target'    => null,
    'rel'       => null,
    'forceCsrf' => false,
    'model'     => null,
])

@aware([
    'labelPosition' => null,
    'requiredIcon'  => config('eloquent-ui.input.required-icon', '*'),
    'requiredStyle' => config('eloquent-ui.input.required-style', 'danger'),
    'labelWidth'    => config('eloquent-ui.input.label-width', 3),
    'rowClass'      => config('eloquent-ui.input.row-class', 'mb-3'),
])

@php
    $computedRel = $rel;
    if ($target === '_blank' && $rel === null) {
        $computedRel = 'noopener noreferrer';
    } elseif ($target === '_blank' && $rel != null && !str_contains($rel, 'noopener')) {
        $computedRel = $rel . ' noopener';
    }
@endphp

<form
    action="{{ $action }}"
    method="{{ strtoupper($method) === 'GET' ? 'get' : 'post' }}"
    @if($files) enctype="multipart/form-data" @endif
    @if($name !== null) id="{{ $name }}" name="{{ $name }}" @endif
    @if($target !== null) target="{{ $target }}" @endif
    @if($computedRel !== null) rel="{{ $computedRel }}" @endif
    {{ $attributes->except([
        'labelPosition',
        'labelIcon',
        'labelStyle',
        'label-position',
        'label-icon',
        'label-style',
        'labelWidth',
        'label-width',
        'rowClass',
        'row-class',
    ]) }}
>
    @if(strtoupper($method) !== 'GET' || $forceCsrf)
        @csrf
    @endif
    @if (strtoupper($method) !== 'POST' && strtoupper($method) !== 'GET')
        @method(strtoupper($method))
    @endif
    {{ $slot }}
</form>
