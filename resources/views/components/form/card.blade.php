<div class="card">
    @isset($header)
        <div {{ $header->attributes->merge(['class' => 'card-header']) }}>{{ $header }}</div>
    @endisset
    <div class="card-body">
        <x-eloquent-ui::form {{ $attributes }}>{{ $slot }}</x-eloquent-ui::form>
    </div>
    @isset($footer)
        <div {{ $footer->attributes->merge(['class' => 'card-footer']) }}>{{ $footer }}</div>
    @endisset
</div>
