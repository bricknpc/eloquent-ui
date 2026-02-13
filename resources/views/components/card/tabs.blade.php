<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            @foreach ($tabs as $id => $title)
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link @if($loop->index === 0) active @endif"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $id }}"
                        type="button"
                        role="tab"
                    >
                        {{ $title }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            {{ $slot }}
        </div>
    </div>
</div>
