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

    /**
     * @throws InvalidColumns
     */
    public function getLabelClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) { // @todo The default is 12 columns, but you can change this, so move this to config
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top    => 'col-12',
            self::Bottom => 'col-12 order-last',
            self::Left   => 'col-sm-' . $labelWidth,
            self::Right  => 'col-sm-' . $labelWidth . ' order-sm-last',
        };
    }

    /**
     * @throws InvalidColumns
     */
    public function getInputClasses(int $labelWidth = 3): string
    {
        if ($labelWidth < 1 || $labelWidth > 12) { // @todo The default is 12 columns, but you can change this, so move this to config
            throw InvalidColumns::forLabel($labelWidth);
        }

        return match ($this) {
            self::Top    => 'col-12',
            self::Bottom => 'col-12 order-first',
            self::Left   => 'col-sm-' . (12 - $labelWidth),
            self::Right  => 'col-sm-' . (12 - $labelWidth) . ' order-sm-first',
        };
    }
}
