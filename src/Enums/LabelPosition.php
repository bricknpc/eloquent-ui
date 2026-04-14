<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Enums;

use BrickNPC\EloquentUI\Exceptions\InvalidColumns;

enum LabelPosition: string
{
    case Top    = 'top';
    case Bottom = 'bottom';
    case Start  = 'start';
    case End    = 'end';

    case Floating = 'floating';

    /**
     * @throws InvalidColumns
     */
    public function getLabelClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) {
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top      => 'col-12',
            self::Bottom   => 'col-12 order-sm-last',
            self::Start    => 'col-sm-' . $labelWidth,
            self::End      => 'col-sm-' . $labelWidth . ' order-sm-last',
            self::Floating => '',
        };
    }

    /**
     * @throws InvalidColumns
     */
    public function getInputClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) {
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top      => 'col-12',
            self::Bottom   => 'col-12 order-sm-first',
            self::Start    => 'col-sm-' . (12 - $labelWidth),
            self::End      => 'col-sm-' . (12 - $labelWidth) . ' order-sm-first',
            self::Floating => '',
        };
    }
}
