<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Exceptions;

class InvalidColumns extends \Exception
{
    public static function forLabel(int $labelWidth): self
    {
        return new self(sprintf('Label width %d is invalid. Label width must be between 1 and 12.', $labelWidth));
    }
}
