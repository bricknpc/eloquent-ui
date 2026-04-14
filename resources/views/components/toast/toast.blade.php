@php
    use function BrickNPC\EloquentUI\ns;
    use BrickNPC\EloquentUI\ValueObjects\Toast;
    use BrickNPC\EloquentUI\Enums\ToastLocation;

    /** @var Toast $toast */
@endphp

@props([
    'toast',
])

<div
    class="toast border-{{ $toast->borderTheme }} w-100 mt-4"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
    data-{{ ns() }}-auto-hide="{{ $toast->autohide ? 'true' : 'false' }}"
    data-{{ ns() }}-auto-hide-delay="{{ $toast->autohideDelayInMs }}"
>
    <div class="toast-header border-bottom border-{{ $toast->borderTheme }}">
        <div class="d-inline-block rounded-1 bg-{{ $toast->theme->getCssClass() }} me-2" style="width: 1rem; height: 1rem;">&nbsp;</div>
        <strong class="me-auto">{{ $toast->theme->getTitle() }}</strong>
        <small>{{ __('now') }}</small>
        <button type="button" class="btn-close text-light" data-bs-dismiss="toast" aria-label="{{ __('Close') }}"></button>
    </div>
    <div class="toast-body">
        <p>
            {{ $toast->title }}
            @if($toast->message)
                <br />
                {{ $toast->message }}
            @endif
        </p>
    </div>
</div>
