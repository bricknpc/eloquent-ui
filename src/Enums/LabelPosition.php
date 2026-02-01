<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Enums;

enum LabelPosition: string
{
    case Top    = 'top';
    case Bottom = 'bottom';
    case Left   = 'left';
    case Right  = 'right';

    public function getLabelClasses(): string
    {
        return match ($this) {
            self::Top    => 'col-12 mb-2',
            self::Bottom => 'col-12 mt-2',
            self::Left   => 'col-sm-3',
            self::Right  => 'col-sm-3 order-sm-last',
        };
    }

    public function getInputClasses(): string
    {
        return match ($this) {
            self::Top    => 'col-12 mt-2',
            self::Bottom => 'col-12 mb-2',
            self::Left   => 'col-sm-9',
            self::Right  => 'col-sm-9 order-sm-first',
        };
    }
}
