<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Casts;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\CoversClass;
use BrickNPC\EloquentUI\ValueObjects\Currency;
use BrickNPC\EloquentUI\Http\Casts\CurrencyCast;

/**
 * @internal
 */
#[CoversClass(CurrencyCast::class)]
class CurrencyCastTest extends TestCase
{
    private CurrencyCast $cast;

    private Model $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cast  = new CurrencyCast();
        $this->model = new class extends Model {};
    }

    public function test_it_casts_cents_to_currency_object(): void
    {
        $attributes = [
            'total_amount'          => 4299,
            'total_amount_currency' => 'USD',
        ];

        $result = $this->cast->get($this->model, 'total_amount', 4299, $attributes);

        $this->assertInstanceOf(Currency::class, $result);
        $this->assertSame(42, $result->whole);
        $this->assertSame(99, $result->cents);
        $this->assertSame(42.99, $result->amount);
        $this->assertSame(4299, $result->amountInCents);
        $this->assertSame('USD', $result->currency);
    }

    public function test_it_handles_zero_amount(): void
    {
        $attributes = [
            'total_amount'          => 0,
            'total_amount_currency' => 'EUR',
        ];

        $result = $this->cast->get($this->model, 'total_amount', 0, $attributes);

        $this->assertSame(0, $result->whole);
        $this->assertSame(0, $result->cents);
        $this->assertSame(0.0, $result->amount);
        $this->assertSame(0, $result->amountInCents);
        $this->assertSame('EUR', $result->currency);
    }

    public function test_it_handles_negative_amounts(): void
    {
        $attributes = [
            'total_amount'          => -4299,
            'total_amount_currency' => 'GBP',
        ];

        $result = $this->cast->get($this->model, 'total_amount', -4299, $attributes);

        $this->assertSame(-42, $result->whole);
        $this->assertSame(99, $result->cents);
        $this->assertSame(-42.99, $result->amount);
        $this->assertSame(-4299, $result->amountInCents);
        $this->assertSame('GBP', $result->currency);
    }

    public function test_it_handles_null_value_on_get(): void
    {
        $attributes = [
            'total_amount'          => null,
            'total_amount_currency' => null,
        ];

        $result = $this->cast->get($this->model, 'total_amount', null, $attributes);

        $this->assertNull($result);
    }

    public function test_it_handles_missing_currency_field(): void
    {
        $attributes = [
            'total_amount' => 5000,
        ];

        $result = $this->cast->get($this->model, 'total_amount', 5000, $attributes);

        $this->assertInstanceOf(Currency::class, $result);
        $this->assertSame(50, $result->whole);
        $this->assertSame(0, $result->cents);
        $this->assertSame(50.0, $result->amount);
        $this->assertSame(5000, $result->amountInCents);
        $this->assertNull($result->currency);
    }

    public function test_it_handles_amounts_less_than_one_dollar(): void
    {
        $attributes = [
            'total_amount'          => 99,
            'total_amount_currency' => 'USD',
        ];

        $result = $this->cast->get($this->model, 'total_amount', 99, $attributes);

        $this->assertSame(0, $result->whole);
        $this->assertSame(99, $result->cents);
        $this->assertSame(0.99, $result->amount);
        $this->assertSame(99, $result->amountInCents);
    }

    public function test_it_sets_currency_object_to_database_values(): void
    {
        $currency = new Currency(
            whole: 42,
            cents: 99,
            amount: 42.99,
            amountInCents: 4299,
            currency: 'USD',
        );

        $result = $this->cast->set($this->model, 'total_amount', $currency, []);

        $this->assertSame([
            'total_amount'          => 4299,
            'total_amount_currency' => 'USD',
        ], $result);
    }

    public function test_it_sets_currency_object_with_null_currency(): void
    {
        $currency = new Currency(
            whole: 100,
            cents: 50,
            amount: 100.50,
            amountInCents: 10050,
            currency: null,
        );

        $result = $this->cast->set($this->model, 'total_amount', $currency, []);

        $this->assertSame([
            'total_amount'          => 10050,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_sets_null_value(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', null, []);

        $this->assertSame([
            'total_amount'          => null,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_sets_integer_value_as_cents(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', 4299, []);

        $this->assertSame([
            'total_amount'          => 4299,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_sets_float_value_as_amount(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', 42.99, []);

        $this->assertSame([
            'total_amount'          => 4299,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_rounds_float_values_correctly(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', 42.996, []);

        $this->assertSame([
            'total_amount'          => 4300,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_sets_array_value_with_snake_case_keys(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', [
            'amount_in_cents' => 4299,
            'currency'        => 'EUR',
        ], []);

        $this->assertSame([
            'total_amount'          => 4299,
            'total_amount_currency' => 'EUR',
        ], $result);
    }

    public function test_it_sets_array_value_with_camel_case_keys(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', [
            'amountInCents' => 5000,
            'currency'      => 'GBP',
        ], []);

        $this->assertSame([
            'total_amount'          => 5000,
            'total_amount_currency' => 'GBP',
        ], $result);
    }

    public function test_it_sets_array_value_without_currency(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', [
            'amount_in_cents' => 1234,
        ], []);

        $this->assertSame([
            'total_amount'          => 1234,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_throws_exception_for_invalid_value_type(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The given value must be a Currency instance, array, integer (cents), or float (amount).');

        $this->cast->set($this->model, 'total_amount', 'invalid', []);
    }

    public function test_it_handles_negative_integer_values(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', -4299, []);

        $this->assertSame([
            'total_amount'          => -4299,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_handles_negative_float_values(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', -42.99, []);

        $this->assertSame([
            'total_amount'          => -4299,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_handles_zero_integer_value(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', 0, []);

        $this->assertSame([
            'total_amount'          => 0,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_handles_zero_float_value(): void
    {
        $result = $this->cast->set($this->model, 'total_amount', 0.0, []);

        $this->assertSame([
            'total_amount'          => 0,
            'total_amount_currency' => null,
        ], $result);
    }

    public function test_it_returns_the_cast_name_when_cast_to_string(): void
    {
        $this->assertSame('currency', (string) $this->cast);
    }
}
