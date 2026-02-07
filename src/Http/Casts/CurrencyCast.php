<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Casts;

use Illuminate\Database\Eloquent\Model;
use BrickNPC\EloquentUI\ValueObjects\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @implements CastsAttributes<Currency, Currency>
 */
class CurrencyCast implements CastsAttributes, \Stringable
{
    /**
     * Get the string representation of the cast.
     */
    public function __toString(): string
    {
        return 'currency';
    }

    /**
     * Cast the given value.
     *
     * @param null|int             $value
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Currency
    {
        if ($value === null) {
            return null;
        }

        $amountInCents = (int) $value;
        $currencyKey   = $key . '_currency';

        /** @var null|string $currencyCode */
        $currencyCode  = $attributes[$currencyKey] ?? null;

        $amount = $amountInCents / 100;
        $whole  = (int) floor(abs($amount));
        $cents  = abs($amountInCents) % 100;

        // Preserve sign for the whole part
        if ($amountInCents < 0) {
            $whole = -$whole;
        }

        return new Currency(
            whole: $whole,
            cents: $cents,
            amount: $amount,
            amountInCents: $amountInCents,
            currency: $currencyCode,
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param null|array<string, float|int|string>|Currency|float|int $value
     * @param array<string, mixed>                                    $attributes
     *
     * @return array<string, mixed>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [
                $key               => null,
                $key . '_currency' => null,
            ];
        }

        if ($value instanceof Currency) {
            return [
                $key               => $value->amountInCents,
                $key . '_currency' => $value->currency,
            ];
        }

        // Support setting with an array
        if (is_array($value)) {
            $amountInCents = $value['amount_in_cents'] ?? $value['amountInCents'] ?? null;
            $currency      = $value['currency']        ?? null;

            return [
                $key               => $amountInCents,
                $key . '_currency' => $currency,
            ];
        }

        // Support setting with an integer (cents)
        if (is_int($value)) {
            return [
                $key               => $value,
                $key . '_currency' => null,
            ];
        }

        // Support setting with a float (amount)
        if (is_float($value)) {
            return [
                $key               => (int) round($value * 100),
                $key . '_currency' => null,
            ];
        }

        throw new \InvalidArgumentException( // @phpstan-ignore-line
            'The given value must be a Currency instance, array, integer (cents), or float (amount).',
        );
    }
}
