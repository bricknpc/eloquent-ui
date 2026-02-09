<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\ValueObjects;

use BrickNPC\EloquentUI\Enums\ToastTheme;

final readonly class Toast
{
    public function __construct(
        public string $title,
        public ?string $message = null,
        public ToastTheme $theme = ToastTheme::Success,
        public bool $autohide = true,
        public int $autohideDelayInMs = 5000,
        public string $borderTheme = 'dark',
    ) {}
}
