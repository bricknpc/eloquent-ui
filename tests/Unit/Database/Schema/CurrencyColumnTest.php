<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Database\Schema;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Database\Schema\ColumnDefinition;
use BrickNPC\EloquentUI\Database\Schema\CurrencyColumn;

/**
 * @internal
 */
#[CoversClass(CurrencyColumn::class)]
class CurrencyColumnTest extends TestCase
{
    private Blueprint $blueprint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blueprint = $this->createMock(Blueprint::class);
    }

    public function test_it_creates_basic_currency_columns(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('amount')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('amount_currency')
            ->willReturn($this->createMock(ColumnDefinition::class))
        ;

        $this->blueprint
            ->expects($this->never())
            ->method('index')
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->create();
    }

    public function test_it_creates_nullable_currency_columns(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);
        $bigIntColumn
            ->expects($this->once())
            ->method('nullable')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('amount')
            ->willReturn($bigIntColumn)
        ;

        $stringColumn = $this->createMock(ColumnDefinition::class);
        $stringColumn
            ->expects($this->once())
            ->method('nullable')
            ->willReturn($stringColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('amount_currency')
            ->willReturn($stringColumn)
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->nullable()->create();
    }

    public function test_it_creates_currency_columns_with_single_index(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('amount')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('amount_currency')
            ->willReturn($this->createMock(ColumnDefinition::class))
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('index')
            ->with('amount')
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->index(false)->create();
    }

    public function test_it_creates_currency_columns_with_composite_index(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('amount')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('amount_currency')
            ->willReturn($this->createMock(ColumnDefinition::class))
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('index')
            ->with(['amount', 'amount_currency'])
        ;

        $column = new CurrencyColumn($this->blueprint, 'amount');
        $column->index(true)->create();
    }

    public function test_it_creates_nullable_currency_columns_with_composite_index(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);
        $bigIntColumn
            ->expects($this->once())
            ->method('nullable')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('total_amount')
            ->willReturn($bigIntColumn)
        ;

        $stringColumn = $this->createMock(ColumnDefinition::class);
        $stringColumn
            ->expects($this->once())
            ->method('nullable')
            ->willReturn($stringColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('total_amount_currency')
            ->willReturn($stringColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('index')
            ->with(['total_amount', 'total_amount_currency'])
        ;

        $column = new CurrencyColumn($this->blueprint, 'total_amount');
        $column->nullable()->index(double: true)->create();
    }

    public function test_it_allows_method_chaining(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);
        $bigIntColumn->method('nullable')->willReturn($bigIntColumn);

        $this->blueprint->method('bigInteger')->willReturn($bigIntColumn);
        $this->blueprint->method('string')->willReturn($this->createMock(ColumnDefinition::class));

        $column = new CurrencyColumn($this->blueprint, 'amount');

        $result = $column->nullable()->index(true);

        $this->assertInstanceOf(CurrencyColumn::class, $result);
    }

    public function test_it_creates_columns_automatically_on_destruct(): void
    {
        $bigIntColumn = $this->createMock(ColumnDefinition::class);

        $this->blueprint
            ->expects($this->once())
            ->method('bigInteger')
            ->with('price')
            ->willReturn($bigIntColumn)
        ;

        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with('price_currency')
            ->willReturn($this->createMock(ColumnDefinition::class))
        ;

        // Don't call create() explicitly - let __destruct handle it
        $column = new CurrencyColumn($this->blueprint, 'price');
        unset($column); // Force destruction
    }
}
