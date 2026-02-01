@props([
    'action',
    'method' => 'post',
    'files' => false,
    'novalidate' => false,
    'autocomplete' => null,
    'name' => null,
    'target' => null,
    'accept-charset' => null,
    'rel' => null,
    'force-csrf' => false,
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
    @if($novalidate) novalidate @endif
    @if($autocomplete !== null) autocomplete="{{ $autocomplete }}" @endif
    @if($name !== null) id="{{ $name }}" name="{{ $name }}" @endif
    @if($target !== null) target="{{ $target }}" @endif
    @if($acceptCharset !== null) accept-charset="{{ $acceptCharset }}" @endif
    @if($computedRel !== null) rel="{{ $computedRel }}" @endif
    {{ $attributes }}
>
    @if(strtoupper($method) !== 'GET' || $forceCsrf)
        @csrf
    @endif
    @if (strtoupper($method) !== 'POST' && strtoupper($method) !== 'GET')
        @method(strtoupper($method))
    @endif
    {{ $slot }}
</form>