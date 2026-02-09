<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Composers;

use Illuminate\Contracts\View\View;
use BrickNPC\EloquentUI\Services\Toaster;

readonly class ToastComposer
{
    public function __construct(
        private Toaster $toaster,
    ) {}

    public function compose(View $view): void
    {
        $view->with('_eloquent_ui__toasts', $this->toaster->getToasts());
    }
}
