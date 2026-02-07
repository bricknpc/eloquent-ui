<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Enums;

use BrickNPC\EloquentUI\Exceptions\InvalidColumns;

enum LabelPosition: string
{
    case Top    = 'top';
    case Bottom = 'bottom';
    case Left   = 'left';
    case Right  = 'right';

    public function getLabelClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) {
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top    => 'col-12',
            self::Bottom => 'col-12 order-sm-last',
            self::Left   => 'col-sm-' . $labelWidth,
            self::Right  => 'col-sm-' . $labelWidth . ' order-sm-last',
        };
    }

    public function getInputClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) {
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top    => 'col-12',
            self::Bottom => 'col-12 order-sm-first',
            self::Left   => 'col-sm-' . (12 - $labelWidth),
            self::Right  => 'col-sm-' . (12 - $labelWidth) . ' order-sm-first',
        };
    }
}
