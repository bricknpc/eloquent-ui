<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Traits;

use Illuminate\Foundation\Http\FormRequest;
use BrickNPC\EloquentUI\ValueObjects\Currency;

/**
 * @mixin FormRequest
 */
trait HasCurrencyInput // @phpstan-ignore trait.unused
{
    public function currency(string $name, mixed $default = null): ?Currency
    {
        $wholeName    = $name . '-whole';
        $centsName    = $name . '-cents';
        $currencyName = $name . '-currency';

        $wholeValue    = $this->input($wholeName, null);
        $centsValue    = $this->input($centsName, null);
        $currencyValue = $this->input($currencyName, null);

        // Convert to integers, treating null/empty as 0
        $wholeIntValue = $wholeValue !== null && $wholeValue !== '' ? (int) $wholeValue : 0;
        $centsIntValue = $centsValue !== null && $centsValue !== '' ? (int) $centsValue : 0;

        // If both inputs are missing/empty, return default
        if (($wholeValue === null || $wholeValue === '') && ($centsValue === null || $centsValue === '')) {
            return $default;
        }

        $amount = $wholeIntValue + ($centsIntValue / 100);

        return new Currency(
            whole: $wholeIntValue,
            cents: $centsIntValue,
            amount: $amount,
            amountInCents: ($wholeIntValue * 100) + $centsIntValue,
            currency: $currencyValue,
        );
    }
}
