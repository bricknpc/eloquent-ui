<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Traits;

use BrickNPC\EloquentUI\Tests\TestCase;
use Illuminate\Foundation\Http\FormRequest;
use PHPUnit\Framework\Attributes\CoversTrait;
use BrickNPC\EloquentUI\ValueObjects\Currency;
use PHPUnit\Framework\Attributes\DataProvider;
use BrickNPC\EloquentUI\Http\Traits\HasCurrencyInput;

/**
 * @internal
 */
#[CoversTrait(HasCurrencyInput::class)]
class HasCurrencyInputTest extends TestCase
{
    private FormRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an anonymous class that uses the trait
        $this->request = new class extends FormRequest {
            use HasCurrencyInput;

            private array $inputData = [];

            public function setInputData(array $data): void
            {
                $this->inputData = $data;
            }

            public function input($key = null, $default = null)
            {
                if ($key === null) {
                    return $this->inputData;
                }

                return $this->inputData[$key] ?? $default;
            }

            public function authorize(): bool
            {
                return true;
            }

            public function rules(): array
            {
                return [];
            }
        };
    }

    public function test_it_creates_currency_from_whole_and_cents_inputs(): void
    {
        $this->request->setInputData([
            'price-whole'    => '42',
            'price-cents'    => '99',
            'price-currency' => 'USD',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(42, $currency->whole);
        $this->assertSame(99, $currency->cents);
        $this->assertSame(42.99, $currency->amount);
        $this->assertSame(4299, $currency->amountInCents);
        $this->assertSame('USD', $currency->currency);
    }

    public function test_it_handles_zero_values(): void
    {
        $this->request->setInputData([
            'price-whole'    => '0',
            'price-cents'    => '0',
            'price-currency' => 'EUR',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(0, $currency->whole);
        $this->assertSame(0, $currency->cents);
        $this->assertSame(0.0, $currency->amount);
        $this->assertSame(0, $currency->amountInCents);
        $this->assertSame('EUR', $currency->currency);
    }

    public function test_it_converts_string_inputs_to_integers(): void
    {
        $this->request->setInputData([
            'price-whole' => '100',
            'price-cents' => '50',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(100, $currency->whole);
        $this->assertSame(50, $currency->cents);
    }

    public function test_it_handles_integer_inputs(): void
    {
        $this->request->setInputData([
            'price-whole' => 100,
            'price-cents' => 50,
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(100, $currency->whole);
        $this->assertSame(50, $currency->cents);
    }

    public function test_it_handles_missing_currency_code(): void
    {
        $this->request->setInputData([
            'price-whole' => '50',
            'price-cents' => '25',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(50, $currency->whole);
        $this->assertSame(25, $currency->cents);
        $this->assertNull($currency->currency);
    }

    public function test_it_returns_default_when_both_whole_and_cents_are_null(): void
    {
        $this->request->setInputData([]);

        $result = $this->request->currency('price');

        $this->assertNull($result);
    }

    public function test_it_returns_custom_default_when_both_whole_and_cents_are_null(): void
    {
        $this->request->setInputData([]);

        $default = new Currency(
            whole: 10,
            cents: 0,
            amount: 10.0,
            amountInCents: 1000,
            currency: 'USD',
        );

        $result = $this->request->currency('price', $default);

        $this->assertSame($default, $result);
    }

    public function test_it_creates_currency_when_only_whole_is_provided(): void
    {
        $this->request->setInputData([
            'price-whole' => '100',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(100, $currency->whole);
        $this->assertSame(0, $currency->cents); // Defaults to 0
        $this->assertSame(100.0, $currency->amount);
        $this->assertSame(10000, $currency->amountInCents);
    }

    public function test_it_creates_currency_when_only_cents_is_provided(): void
    {
        $this->request->setInputData([
            'price-cents' => '50',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(0, $currency->whole); // Defaults to 0
        $this->assertSame(50, $currency->cents);
        $this->assertSame(0.5, $currency->amount);
        $this->assertSame(50, $currency->amountInCents);
    }

    public function test_it_calculates_amount_correctly(): void
    {
        $this->request->setInputData([
            'price-whole' => '42',
            'price-cents' => '99',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(42.99, $currency->amount);
    }

    public function test_it_calculates_amount_in_cents_correctly(): void
    {
        $this->request->setInputData([
            'price-whole' => '42',
            'price-cents' => '99',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(4299, $currency->amountInCents);
    }

    public function test_it_handles_amounts_less_than_one_dollar(): void
    {
        $this->request->setInputData([
            'price-whole' => '0',
            'price-cents' => '99',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(0, $currency->whole);
        $this->assertSame(99, $currency->cents);
        $this->assertSame(0.99, $currency->amount);
        $this->assertSame(99, $currency->amountInCents);
    }

    public function test_it_uses_different_field_names(): void
    {
        $this->request->setInputData([
            'total-whole'    => '100',
            'total-cents'    => '50',
            'total-currency' => 'GBP',
        ]);

        $currency = $this->request->currency('total');

        $this->assertSame(100, $currency->whole);
        $this->assertSame(50, $currency->cents);
        $this->assertSame('GBP', $currency->currency);
    }

    public function test_it_handles_large_amounts(): void
    {
        $this->request->setInputData([
            'price-whole' => '999999',
            'price-cents' => '99',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(999999, $currency->whole);
        $this->assertSame(99, $currency->cents);
        $this->assertSame(999999.99, $currency->amount);
        $this->assertSame(99999999, $currency->amountInCents);
    }

    #[DataProvider('currencyInputProvider')]
    public function test_it_handles_various_currency_input_combinations(
        ?string $whole,
        ?string $cents,
        ?string $currency,
        bool $shouldReturnCurrency,
        ?int $expectedWhole = null,
        ?int $expectedCents = null,
    ): void {
        $inputData = [];

        if ($whole !== null) {
            $inputData['price-whole'] = $whole;
        }
        if ($cents !== null) {
            $inputData['price-cents'] = $cents;
        }
        if ($currency !== null) {
            $inputData['price-currency'] = $currency;
        }

        $this->request->setInputData($inputData);

        $result = $this->request->currency('price');

        if ($shouldReturnCurrency) {
            $this->assertInstanceOf(Currency::class, $result);
            if ($expectedWhole !== null) {
                $this->assertSame($expectedWhole, $result->whole);
            }
            if ($expectedCents !== null) {
                $this->assertSame($expectedCents, $result->cents);
            }
        } else {
            $this->assertNull($result);
        }
    }

    // Data providers

    public static function currencyInputProvider(): array
    {
        return [
            'both values present' => ['100', '50', 'USD', true, 100, 50],
            'only whole present'  => ['100', null, 'USD', true, 100, 0],
            'only cents present'  => [null, '50', 'USD', true, 0, 50],
            'both null'           => [null, null, 'USD', false],
            'all present'         => ['42', '99', 'EUR', true, 42, 99],
            'no currency code'    => ['10', '20', null, true, 10, 20],
            'zero values'         => ['0', '0', 'GBP', true, 0, 0],
        ];
    }

    public function test_it_handles_empty_string_inputs_as_zero(): void
    {
        $this->request->setInputData([
            'price-whole' => '',
            'price-cents' => '',
        ]);

        // Empty strings should return default since both are empty
        $result = $this->request->currency('price');

        $this->assertNull($result);
    }

    public function test_it_handles_empty_string_for_whole_only(): void
    {
        $this->request->setInputData([
            'price-whole' => '',
            'price-cents' => '50',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(0, $currency->whole);
        $this->assertSame(50, $currency->cents);
    }

    public function test_it_handles_empty_string_for_cents_only(): void
    {
        $this->request->setInputData([
            'price-whole' => '100',
            'price-cents' => '',
        ]);

        $currency = $this->request->currency('price');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame(100, $currency->whole);
        $this->assertSame(0, $currency->cents);
    }

    public function test_it_handles_null_currency_value(): void
    {
        $this->request->setInputData([
            'price-whole'    => '10',
            'price-cents'    => '50',
            'price-currency' => null,
        ]);

        $currency = $this->request->currency('price');

        $this->assertNull($currency->currency);
    }

    public function test_it_handles_zero_whole_and_non_zero_cents(): void
    {
        $this->request->setInputData([
            'price-whole' => '0',
            'price-cents' => '5',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(0, $currency->whole);
        $this->assertSame(5, $currency->cents);
        $this->assertSame(0.05, $currency->amount);
        $this->assertSame(5, $currency->amountInCents);
    }

    public function test_it_handles_non_zero_whole_and_zero_cents(): void
    {
        $this->request->setInputData([
            'price-whole' => '100',
            'price-cents' => '0',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(100, $currency->whole);
        $this->assertSame(0, $currency->cents);
        $this->assertSame(100.0, $currency->amount);
        $this->assertSame(10000, $currency->amountInCents);
    }

    public function test_it_handles_numeric_string_with_leading_zeros(): void
    {
        $this->request->setInputData([
            'price-whole' => '0042',
            'price-cents' => '09',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(42, $currency->whole);
        $this->assertSame(9, $currency->cents);
    }

    public function test_it_handles_negative_values_when_cast_to_int(): void
    {
        $this->request->setInputData([
            'price-whole' => '-10',
            'price-cents' => '50',
        ]);

        $currency = $this->request->currency('price');

        $this->assertSame(-10, $currency->whole);
        $this->assertSame(50, $currency->cents);
        $this->assertSame(-9.5, $currency->amount);
        $this->assertSame(-950, $currency->amountInCents);
    }

    public function test_it_returns_default_when_both_are_empty_strings(): void
    {
        $this->request->setInputData([
            'price-whole' => '',
            'price-cents' => '',
        ]);

        $default = new Currency(
            whole: 5,
            cents: 0,
            amount: 5.0,
            amountInCents: 500,
            currency: 'USD',
        );

        $result = $this->request->currency('price', $default);

        $this->assertSame($default, $result);
    }
}
