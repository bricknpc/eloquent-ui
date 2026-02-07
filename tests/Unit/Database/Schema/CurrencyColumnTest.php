<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Database\Schema;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Database\Schema\ColumnDefinition;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use BrickNPC\EloquentUI\Database\Schema\CurrencyColumn;

/**
 * @internal
 */
#[CoversClass(CurrencyColumn::class)]
class CurrencyColumnTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private Blueprint $blueprint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blueprint = \Mockery::mock(Blueprint::class);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function test_it_creates_basic_currency_columns(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('amount')
            ->andReturn($bigIntColumn)
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('amount_currency')
            ->andReturn($stringColumn)
        ;

        $this->blueprint
            ->shouldNotReceive('index')
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->create();
    }

    public function test_it_creates_nullable_currency_columns(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->once()
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('amount')
            ->andReturn($bigIntColumn)
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->once()
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('amount_currency')
            ->andReturn($stringColumn)
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->nullable()->create();
    }

    public function test_it_creates_currency_columns_with_single_index(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('amount')
            ->andReturn($bigIntColumn)
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('amount_currency')
            ->andReturn($stringColumn)
        ;

        $this->blueprint
            ->shouldReceive('index')
            ->once()
            ->with('amount')
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->index(false)->create();
    }

    public function test_it_creates_currency_columns_with_composite_index(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('amount')
            ->andReturn($bigIntColumn)
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('amount_currency')
            ->andReturn($stringColumn)
        ;

        $this->blueprint
            ->shouldReceive('index')
            ->once()
            ->with(['amount', 'amount_currency'])
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->index(true)->create();
    }

    public function test_it_creates_nullable_currency_columns_with_composite_index(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->once()
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('total_amount')
            ->andReturn($bigIntColumn)
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->once()
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('total_amount_currency')
            ->andReturn($stringColumn)
        ;

        $this->blueprint
            ->shouldReceive('index')
            ->once()
            ->with(['total_amount', 'total_amount_currency'])
        ;

        $column = new CurrencyColumn($this->blueprint, 'total_amount');
        $column->nullable()->index(double: true)->create();
    }

    public function test_it_allows_method_chaining(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);
        $bigIntColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->andReturn($bigIntColumn)
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->andReturn($stringColumn)
        ;

        $this->blueprint
            ->shouldReceive('index')
            ->andReturnSelf()
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');

        $result = $column->nullable()->index(true);

        $this->assertInstanceOf(CurrencyColumn::class, $result);
    }

    public function test_it_creates_columns_automatically_on_destruct(): void
    {
        $bigIntColumn = \Mockery::mock(ColumnDefinition::class);

        $stringColumn = \Mockery::mock(ColumnDefinition::class);
        $stringColumn
            ->shouldReceive('nullable')
            ->andReturnSelf()
        ;

        $this->blueprint
            ->shouldReceive('bigInteger')
            ->once()
            ->with('price')
            ->andReturn($bigIntColumn)
        ;

        $this->blueprint
            ->shouldReceive('string')
            ->once()
            ->with('price_currency')
            ->andReturn($stringColumn)
        ;

        // Don't call create() explicitly - let __destruct handle it
        $column = new CurrencyColumn($this->blueprint, 'price');
        unset($column); // Force destruction
    }
}
