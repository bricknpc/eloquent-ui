<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Enums;

use function BrickNPC\EloquentUI\__;

enum ToastTheme: string
{
    case Success   = 'success';
    case Warning   = 'warning';
    case Danger    = 'danger';
    case Info      = 'info';

    public function getCssClass(): string
    {
        return $this->value;
    }

    public function getTitle(): string
    {
        return match ($this) {
            self::Success => __('Success'),
            self::Warning => __('Warning'),
            self::Danger  => __('Error'),
            self::Info    => __('Info'),
        };
    }
}
