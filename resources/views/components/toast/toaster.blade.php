@php
    use BrickNPC\EloquentUI\Enums\ToastLocation;

    /** @var ToastLocation $location */
@endphp

@props([
    'location' => ToastLocation::BottomRight,
])

@if(isset($_eloquent_ui__toasts) && is_array($_eloquent_ui__toasts) && count($_eloquent_ui__toasts) > 0)
    <div {{ $attributes->merge(['class' => $location->getCssClass()]) }}>
        @foreach($_eloquent_ui__toasts as $toast)
            <x-eloquent-ui::toast.toast :toast="$toast" />
        @endforeach
    </div>
@endif