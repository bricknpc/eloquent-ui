<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Rules;

use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Http\Rules\Currency;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversFunction;

/**
 * @internal
 */
#[CoversClass(Currency::class)]
#[CoversFunction('BrickNPC\EloquentUI\__')]
class CurrencyTest extends TestCase
{
    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('validCurrencyProvider')]
    public function test_it_passes_validation_for_valid_currency(
        bool $required,
        ?float $min,
        ?float $max,
        ?array $currencies,
        array $data,
    ): void {
        $rule = new Currency($required, $min, $max, $currencies);
        $rule->setData($data);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, 'Validation should pass but it failed');
    }

    /**
     * @return array<string, array{bool, ?float, ?float, ?array<string, string>, array<string, mixed>}>
     */
    public static function validCurrencyProvider(): array
    {
        return [
            'simple valid amount' => [
                false, // required
                null,  // min
                null,  // max
                null,  // currencies
                ['amount-whole' => '100', 'amount-cents' => '50'],
            ],
            'zero amount' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '0', 'amount-cents' => '00'],
            ],
            'large amount' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '999999', 'amount-cents' => '99'],
            ],
            'with valid currency' => [
                false,
                null,
                null,
                ['USD'          => 'US Dollar', 'EUR' => 'Euro'],
                ['amount-whole' => '100', 'amount-cents' => '50', 'amount-currency' => 'EUR'],
            ],
            'within min and max range' => [
                false,
                10.00,
                500.00,
                null,
                ['amount-whole' => '250', 'amount-cents' => '00'],
            ],
            'required with valid data' => [
                true,
                null,
                null,
                null,
                ['amount-whole' => '100', 'amount-cents' => '50'],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('invalidCurrencyProvider')]
    public function test_it_fails_validation_for_invalid_currency(
        bool $required,
        ?float $min,
        ?float $max,
        ?array $currencies,
        array $data,
        string $expectedErrorKey,
    ): void {
        $rule = new Currency($required, $min, $max, $currencies);
        $rule->setData($data);

        $failed       = false;
        $errorMessage = null;

        $rule->validate('amount', null, function ($message) use (&$failed, &$errorMessage) {
            $failed       = true;
            $errorMessage = $message;
        });

        $this->assertTrue($failed, 'Validation should fail but it passed');
        $this->assertNotNull($errorMessage);
    }

    /**
     * @return array<string, array{bool, ?float, ?float, ?array<string, string>, array<string, mixed>, string}>
     */
    public static function invalidCurrencyProvider(): array
    {
        return [
            'required but whole is empty' => [
                true,
                null,
                null,
                null,
                ['amount-whole' => '', 'amount-cents' => '50'],
                'required',
            ],
            'required but cents is empty' => [
                true,
                null,
                null,
                null,
                ['amount-whole' => '100', 'amount-cents' => ''],
                'required',
            ],
            'whole is not a digit' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => 'abc', 'amount-cents' => '50'],
                'whole',
            ],
            'whole contains negative sign' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '-100', 'amount-cents' => '50'],
                'whole',
            ],
            'cents length is one' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '100', 'amount-cents' => '5'],
                'cents',
            ],
            'cents length is three' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '100', 'amount-cents' => '500'],
                'cents',
            ],
            'cents exceeds 99' => [
                false,
                null,
                null,
                null,
                ['amount-whole' => '100', 'amount-cents' => '100'],
                'cents',
            ],
            'below minimum' => [
                false,
                100.00,
                null,
                null,
                ['amount-whole' => '50', 'amount-cents' => '00'],
                'min',
            ],
            'exceeds maximum' => [
                false,
                null,
                500.00,
                null,
                ['amount-whole' => '600', 'amount-cents' => '00'],
                'max',
            ],
            'invalid currency code' => [
                false,
                null,
                null,
                ['USD'          => 'US Dollar'],
                ['amount-whole' => '100', 'amount-cents' => '00', 'amount-currency' => 'EUR'],
                'currency',
            ],
        ];
    }

    public function test_it_passes_when_not_required_and_whole_is_empty(): void
    {
        $rule = new Currency(required: false);
        $rule->setData([
            'amount-whole' => '',
            'amount-cents' => '00',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_fails_when_required_and_whole_is_empty(): void
    {
        $rule = new Currency(required: true);
        $rule->setData([
            'amount-whole' => '',
            'amount-cents' => '00',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_required_and_cents_is_empty(): void
    {
        $rule = new Currency(required: true);
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_whole_is_not_a_digit(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => 'abc',
            'amount-cents' => '50',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_whole_contains_decimal(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => '100.5',
            'amount-cents' => '50',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_cents_length_is_not_two(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '5', // Should be '05'
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_cents_is_greater_than_99(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '100', // Invalid, must be 00-99
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_cents_is_negative(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '-5',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_fails_when_value_is_below_minimum(): void
    {
        $rule = new Currency(min: 100.00);
        $rule->setData([
            'amount-whole' => '99',
            'amount-cents' => '99',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_passes_when_value_equals_minimum(): void
    {
        $rule = new Currency(min: 100.00);
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '00',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_fails_when_value_exceeds_maximum(): void
    {
        $rule = new Currency(max: 1000.00);
        $rule->setData([
            'amount-whole' => '1000',
            'amount-cents' => '01',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_passes_when_value_equals_maximum(): void
    {
        $rule = new Currency(max: 1000.00);
        $rule->setData([
            'amount-whole' => '1000',
            'amount-cents' => '00',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_validates_value_is_within_min_max_range(): void
    {
        $rule = new Currency(min: 50.00, max: 200.00);
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '50',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_passes_when_currency_is_in_allowed_list(): void
    {
        $rule = new Currency(currencies: ['USD' => 'US Dollar', 'EUR' => 'Euro']);
        $rule->setData([
            'amount-whole'    => '100',
            'amount-cents'    => '00',
            'amount-currency' => 'USD',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_fails_when_currency_is_not_in_allowed_list(): void
    {
        $rule = new Currency(currencies: ['USD' => 'US Dollar', 'EUR' => 'Euro']);
        $rule->setData([
            'amount-whole'    => '100',
            'amount-cents'    => '00',
            'amount-currency' => 'GBP',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    public function test_it_passes_when_currencies_not_specified(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole'    => '100',
            'amount-cents'    => '00',
            'amount-currency' => 'ANYTHING',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_passes_when_currencies_specified_but_currency_field_missing(): void
    {
        $rule = new Currency(currencies: ['USD' => 'US Dollar']);
        $rule->setData([
            'amount-whole' => '100',
            'amount-cents' => '00',
            // No 'amount-currency' key
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_it_defaults_cents_to_00_when_missing(): void
    {
        $rule = new Currency();
        $rule->setData([
            'amount-whole' => '100',
            // No cents provided
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_set_data_returns_instance(): void
    {
        $rule   = new Currency();
        $result = $rule->setData(['amount-whole' => '100', 'amount-cents' => '00']);

        $this->assertInstanceOf(Currency::class, $result);
        $this->assertSame($rule, $result);
    }

    public function test_it_calculates_value_correctly_from_whole_and_cents(): void
    {
        $rule = new Currency(min: 150.75, max: 150.75);
        $rule->setData([
            'amount-whole' => '150',
            'amount-cents' => '75',
        ]);

        $failed = false;
        $rule->validate('amount', null, function () use (&$failed) {
            $failed = true;
        });

        // If value calculation is correct (150 + 0.75 = 150.75), it should pass
        $this->assertFalse($failed);
    }
}
