<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\ValueObjects;

final readonly class Currency
{
    public function __construct(
        public int $whole,
        public int $cents,
        public float $amount,
        public int $amountInCents,
        public ?string $currency = null,
    ) {}
}
