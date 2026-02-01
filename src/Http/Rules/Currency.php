<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Rules;

use function BrickNPC\EloquentUI\__;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Currency implements ValidationRule, DataAwareRule
{
    /**
     * @var array<string, mixed>
     */
    public array $data = []; // @phpstan-ignore-line

    /**
     * @var array<string, string>
     */
    private array $errorMessages = [
        'required' => 'The :attribute field is required.',
        'min'      => 'The :attribute must be at least :min.',
        'max'      => 'The :attribute may not be greater than :max.',
        'currency' => 'The :attribute must have a valid currency.',
        'whole'    => 'The :attribute must have a valid whole number.',
        'cents'    => 'The :attribute must have a valid cents value between 00 and 99.',
    ];

    /**
     * @param null|array<int, string> $currencies
     */
    public function __construct(
        private readonly bool $required = false,
        private readonly ?float $min = null,
        private readonly ?float $max = null,
        private readonly ?array $currencies = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param \Closure(null|string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $wholeName    = $attribute . '-whole';
        $centsName    = $attribute . '-cents';
        $currencyName = $attribute . '-currency';

        if ($this->required && (empty($this->data[$wholeName]) || empty($this->data[$centsName]))) {
            $fail(__($this->errorMessages['required']));
        }

        // If the field is not required and the value is empty, return early.
        if (!$this->required && empty($this->data[$wholeName])) {
            return;
        }

        $this->validateWhole($wholeName, $fail);
        $this->validateCents($centsName, $fail);
        $this->validateCurrency($currencyName, $fail);

        /** @var string $wholeValue */
        $wholeValue = $this->data[$wholeName];

        /** @var string $centsValue */
        $centsValue = $this->data[$centsName];

        $value = ((int) $wholeValue) + ((int) $centsValue) / 100;

        $this->validateMinMax($value, $fail);
    }

    /**
     * @param \Closure(null|string): PotentiallyTranslatedString $fail
     */
    private function validateWhole(string $name, \Closure $fail): void
    {
        $wholeValue = $this->data[$name];

        if (!ctype_digit($wholeValue)) {
            $fail(__($this->errorMessages['whole']));
        }
    }

    /**
     * @param \Closure(null|string): PotentiallyTranslatedString $fail
     */
    private function validateCents(string $name, \Closure $fail): void
    {
        /** @var string $centsValue */
        $centsValue = $this->data[$name] ?? '00';

        if (strlen($centsValue) !== 2) {
            $fail(__($this->errorMessages['cents']));
        }

        $centsIntValue = (int) $centsValue;

        if ($centsIntValue < 0 || $centsIntValue > 99) {
            $fail(__($this->errorMessages['cents']));
        }
    }

    /**
     * @param \Closure(null|string): PotentiallyTranslatedString $fail
     */
    private function validateCurrency(string $name, \Closure $fail): void
    {
        if ($this->currencies === null) {
            return;
        }

        if (!isset($this->data[$name])) {
            return;
        }

        if (!in_array($this->data[$name], array_keys($this->currencies), true)) {
            $fail(__($this->errorMessages['currency']));
        }
    }

    /**
     * @param \Closure(null|string): PotentiallyTranslatedString $fail
     */
    private function validateMinMax(float $value, \Closure $fail): void
    {
        if ($this->min !== null && $value < $this->min) {
            $fail(__($this->errorMessages['min'], ['min' => $this->min]));
        }

        if ($this->max !== null && $value > $this->max) {
            $fail(__($this->errorMessages['max'], ['max' => $this->max]));
        }
    }
}
