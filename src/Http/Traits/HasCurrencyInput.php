<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Traits;

use Illuminate\Foundation\Http\FormRequest;
use BrickNPC\EloquentUI\ValueObjects\CurrencyInput;

/**
 * @mixin FormRequest
 */
trait HasCurrencyInput // @phpstan-ignore trait.unused
{
    public function currency(string $name, mixed $default = null): ?CurrencyInput
    {
        $wholeName    = $name . '-whole';
        $centsName    = $name . '-cents';
        $currencyName = $name . '-currency';

        $wholeValue    = $this->input($wholeName, null);
        $centsValue    = $this->input($centsName, null);
        $currencyValue = $this->input($currencyName, null);

        $wholeIntValue = $wholeValue    !== null ? (int) $wholeValue : null;
        $centsIntValue = $centsValue    !== null ? (int) $centsValue : null;
        $amount        = $wholeIntValue        !== null && $centsIntValue !== null
            ? $wholeIntValue + ($centsIntValue / 100)
            : null;

        if ($wholeIntValue === null && $centsIntValue === null) {
            return $default;
        }

        return new CurrencyInput(
            whole: $wholeIntValue,
            cents: $centsIntValue,
            amount: $amount,
            amountInCents: ($wholeIntValue * 100) + $centsIntValue,
            currency: $currencyValue,
        );
    }
}
