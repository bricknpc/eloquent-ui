<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Enums;

enum ToastLocation: string
{
    case TopLeft      = 'top-left';
    case TopRight     = 'top-right';
    case BottomLeft   = 'bottom-left';
    case BottomRight  = 'bottom-right';
    case TopCenter    = 'top-center';
    case BottomCenter = 'bottom-center';
    case LeftMiddle   = 'left-middle';
    case RightMiddle  = 'right-middle';

    public function getCssClass(): string
    {
        $locationSpecific = match ($this) {
            self::TopLeft      => 'top-0 start-0',
            self::TopRight     => 'top-0 end-0',
            self::BottomLeft   => 'bottom-0 start-0',
            self::BottomRight  => 'bottom-0 end-0',
            self::TopCenter    => 'top-0 start-50 translate-middle-x',
            self::BottomCenter => 'bottom-0 start-50 translate-middle-x',
            self::LeftMiddle   => 'top-50 start-0 translate-middle-y',
            self::RightMiddle  => 'top-50 end-0 translate-middle-y',
        };

        return 'position-fixed toast-container ' . $locationSpecific;
    }
}
