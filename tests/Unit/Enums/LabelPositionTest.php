<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Enums;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\UsesClass;
use BrickNPC\EloquentUI\Enums\LabelPosition;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use BrickNPC\EloquentUI\Exceptions\InvalidColumns;
use BrickNPC\EloquentUI\Exceptions\EloquentUIException;

/**
 * @internal
 */
#[CoversClass(LabelPosition::class)]
#[UsesClass(EloquentUIException::class)]
#[UsesClass(InvalidColumns::class)]
class LabelPositionTest extends TestCase
{
    public function test_it_has_all_expected_cases(): void
    {
        $cases = LabelPosition::cases();

        $this->assertCount(4, $cases);
        $this->assertContains(LabelPosition::Top, $cases);
        $this->assertContains(LabelPosition::Bottom, $cases);
        $this->assertContains(LabelPosition::Left, $cases);
        $this->assertContains(LabelPosition::Right, $cases);
    }

    public function test_it_has_correct_values(): void
    {
        $this->assertSame('top', LabelPosition::Top->value);
        $this->assertSame('bottom', LabelPosition::Bottom->value);
        $this->assertSame('left', LabelPosition::Left->value);
        $this->assertSame('right', LabelPosition::Right->value);
    }

    // getLabelClasses() tests

    public function test_it_returns_correct_label_classes_for_top_position(): void
    {
        $this->assertSame('col-12', LabelPosition::Top->getLabelClasses());
        $this->assertSame('col-12', LabelPosition::Top->getLabelClasses(3));
        $this->assertSame('col-12', LabelPosition::Top->getLabelClasses(6));
    }

    public function test_it_returns_correct_label_classes_for_bottom_position(): void
    {
        $this->assertSame('col-12 order-sm-last', LabelPosition::Bottom->getLabelClasses());
        $this->assertSame('col-12 order-sm-last', LabelPosition::Bottom->getLabelClasses(3));
        $this->assertSame('col-12 order-sm-last', LabelPosition::Bottom->getLabelClasses(6));
    }

    #[DataProvider('labelWidthProvider')]
    public function test_it_returns_correct_label_classes_for_left_position(int $labelWidth, string $expected): void
    {
        $this->assertSame($expected, LabelPosition::Left->getLabelClasses($labelWidth));
    }

    #[DataProvider('labelWidthProvider')]
    public function test_it_returns_correct_label_classes_for_right_position(int $labelWidth, string $expected): void
    {
        $expectedWithOrder = $expected . ' order-sm-last';
        $this->assertSame($expectedWithOrder, LabelPosition::Right->getLabelClasses($labelWidth));
    }

    // Data providers

    public static function labelWidthProvider(): array
    {
        return [
            'width 1'  => [1, 'col-sm-1'],
            'width 2'  => [2, 'col-sm-2'],
            'width 3'  => [3, 'col-sm-3'],
            'width 4'  => [4, 'col-sm-4'],
            'width 5'  => [5, 'col-sm-5'],
            'width 6'  => [6, 'col-sm-6'],
            'width 7'  => [7, 'col-sm-7'],
            'width 8'  => [8, 'col-sm-8'],
            'width 9'  => [9, 'col-sm-9'],
            'width 10' => [10, 'col-sm-10'],
            'width 11' => [11, 'col-sm-11'],
            'width 12' => [12, 'col-sm-12'],
        ];
    }

    public function test_it_uses_default_label_width_of_3(): void
    {
        $this->assertSame('col-sm-3', LabelPosition::Left->getLabelClasses());
        $this->assertSame('col-sm-3 order-sm-last', LabelPosition::Right->getLabelClasses());
    }

    #[DataProvider('invalidLabelWidthProvider')]
    public function test_it_throws_exception_for_invalid_label_width_in_get_label_classes(int $invalidWidth): void
    {
        $this->expectException(InvalidColumns::class);

        LabelPosition::Top->getLabelClasses($invalidWidth);
    }

    #[DataProvider('invalidLabelWidthProvider')]
    public function test_it_throws_exception_for_invalid_label_width_in_get_label_classes_for_all_positions(int $invalidWidth): void
    {
        foreach (LabelPosition::cases() as $position) {
            try {
                $position->getLabelClasses($invalidWidth);
                $this->fail("Expected InvalidColumns exception for position {$position->value} with width {$invalidWidth}");
            } catch (InvalidColumns $e) {
                $this->assertInstanceOf(InvalidColumns::class, $e);
            }
        }
    }

    // getInputClasses() tests

    public function test_it_returns_correct_input_classes_for_top_position(): void
    {
        $this->assertSame('col-12', LabelPosition::Top->getInputClasses());
        $this->assertSame('col-12', LabelPosition::Top->getInputClasses(3));
        $this->assertSame('col-12', LabelPosition::Top->getInputClasses(6));
    }

    public function test_it_returns_correct_input_classes_for_bottom_position(): void
    {
        $this->assertSame('col-12 order-sm-first', LabelPosition::Bottom->getInputClasses());
        $this->assertSame('col-12 order-sm-first', LabelPosition::Bottom->getInputClasses(3));
        $this->assertSame('col-12 order-sm-first', LabelPosition::Bottom->getInputClasses(6));
    }

    #[DataProvider('inputWidthProvider')]
    public function test_it_returns_correct_input_classes_for_left_position(int $labelWidth, string $expected): void
    {
        $this->assertSame($expected, LabelPosition::Left->getInputClasses($labelWidth));
    }

    #[DataProvider('inputWidthProvider')]
    public function test_it_returns_correct_input_classes_for_right_position(int $labelWidth, string $expected): void
    {
        $expectedWithOrder = $expected . ' order-sm-first';
        $this->assertSame($expectedWithOrder, LabelPosition::Right->getInputClasses($labelWidth));
    }

    public static function inputWidthProvider(): array
    {
        return [
            'label 1 -> input 11'  => [1, 'col-sm-11'],
            'label 2 -> input 10'  => [2, 'col-sm-10'],
            'label 3 -> input 9'   => [3, 'col-sm-9'],
            'label 4 -> input 8'   => [4, 'col-sm-8'],
            'label 5 -> input 7'   => [5, 'col-sm-7'],
            'label 6 -> input 6'   => [6, 'col-sm-6'],
            'label 7 -> input 5'   => [7, 'col-sm-5'],
            'label 8 -> input 4'   => [8, 'col-sm-4'],
            'label 9 -> input 3'   => [9, 'col-sm-3'],
            'label 10 -> input 2'  => [10, 'col-sm-2'],
            'label 11 -> input 1'  => [11, 'col-sm-1'],
            'label 12 -> input 0'  => [12, 'col-sm-0'],
        ];
    }

    public function test_it_calculates_input_width_correctly(): void
    {
        // labelWidth 1 -> inputWidth 11
        $this->assertSame('col-sm-11', LabelPosition::Left->getInputClasses(1));

        // labelWidth 3 -> inputWidth 9
        $this->assertSame('col-sm-9', LabelPosition::Left->getInputClasses(3));

        // labelWidth 6 -> inputWidth 6
        $this->assertSame('col-sm-6', LabelPosition::Left->getInputClasses(6));

        // labelWidth 12 -> inputWidth 0
        $this->assertSame('col-sm-0', LabelPosition::Left->getInputClasses(12));
    }

    #[DataProvider('invalidLabelWidthProvider')]
    public function test_it_throws_exception_for_invalid_label_width_in_get_input_classes(int $invalidWidth): void
    {
        $this->expectException(InvalidColumns::class);

        LabelPosition::Top->getInputClasses($invalidWidth);
    }

    #[DataProvider('invalidLabelWidthProvider')]
    public function test_it_throws_exception_for_invalid_label_width_in_get_input_classes_for_all_positions(int $invalidWidth): void
    {
        foreach (LabelPosition::cases() as $position) {
            try {
                $position->getInputClasses($invalidWidth);
                $this->fail("Expected InvalidColumns exception for position {$position->value} with width {$invalidWidth}");
            } catch (InvalidColumns $e) {
                $this->assertInstanceOf(InvalidColumns::class, $e);
            }
        }
    }

    public static function invalidLabelWidthProvider(): array
    {
        return [
            'zero'           => [0],
            'negative one'   => [-1],
            'negative large' => [-100],
            'thirteen'       => [13],
            'large positive' => [100],
        ];
    }

    // Edge cases

    public function test_it_handles_minimum_valid_label_width(): void
    {
        $this->assertSame('col-sm-1', LabelPosition::Left->getLabelClasses(1));
        $this->assertSame('col-sm-11', LabelPosition::Left->getInputClasses(1));
    }

    public function test_it_handles_maximum_valid_label_width(): void
    {
        $this->assertSame('col-sm-12', LabelPosition::Left->getLabelClasses(12));
        $this->assertSame('col-sm-0', LabelPosition::Left->getInputClasses(12));
    }
}
