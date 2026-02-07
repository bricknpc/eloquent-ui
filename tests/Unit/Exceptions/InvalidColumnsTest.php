<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Exceptions;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use BrickNPC\EloquentUI\Exceptions\InvalidColumns;

/**
 * @internal
 */
#[CoversClass(InvalidColumns::class)]
class InvalidColumnsTest extends TestCase
{
    public function test_it_extends_exception(): void
    {
        $exception = InvalidColumns::forLabel(0);

        $this->assertInstanceOf(\Exception::class, $exception);
        $this->assertInstanceOf(\Throwable::class, $exception);
    }

    public function test_it_creates_exception_for_label_with_correct_message(): void
    {
        $exception = InvalidColumns::forLabel(0);

        $this->assertSame(
            'Label width 0 is invalid. Label width must be between 1 and 12.',
            $exception->getMessage(),
        );
    }

    #[DataProvider('invalidLabelWidthProvider')]
    public function test_it_creates_exception_with_correct_message_for_various_widths(int $width, string $expectedMessage): void
    {
        $exception = InvalidColumns::forLabel($width);

        $this->assertSame($expectedMessage, $exception->getMessage());
    }

    // Data providers

    public static function invalidLabelWidthProvider(): array
    {
        return [
            'zero' => [
                0,
                'Label width 0 is invalid. Label width must be between 1 and 12.',
            ],
            'negative one' => [
                -1,
                'Label width -1 is invalid. Label width must be between 1 and 12.',
            ],
            'thirteen' => [
                13,
                'Label width 13 is invalid. Label width must be between 1 and 12.',
            ],
            'large negative' => [
                -100,
                'Label width -100 is invalid. Label width must be between 1 and 12.',
            ],
            'large positive' => [
                100,
                'Label width 100 is invalid. Label width must be between 1 and 12.',
            ],
        ];
    }

    public function test_it_returns_new_instance_each_time(): void
    {
        $exception1 = InvalidColumns::forLabel(0);
        $exception2 = InvalidColumns::forLabel(0);

        $this->assertNotSame($exception1, $exception2);
        $this->assertEquals($exception1->getMessage(), $exception2->getMessage());
    }

    public function test_it_can_be_thrown_and_caught(): void
    {
        $this->expectException(InvalidColumns::class);
        $this->expectExceptionMessage('Label width 13 is invalid. Label width must be between 1 and 12.');

        throw InvalidColumns::forLabel(13);
    }

    public function test_it_has_default_exception_code_zero(): void
    {
        $exception = InvalidColumns::forLabel(0);

        $this->assertSame(0, $exception->getCode());
    }

    public function test_it_has_no_previous_exception_by_default(): void
    {
        $exception = InvalidColumns::forLabel(0);

        $this->assertNull($exception->getPrevious());
    }

    #[DataProvider('labelWidthEdgeCasesProvider')]
    public function test_it_handles_edge_case_values(int $width): void
    {
        $exception = InvalidColumns::forLabel($width);

        $this->assertInstanceOf(InvalidColumns::class, $exception);
        $this->assertStringContainsString((string) $width, $exception->getMessage());
        $this->assertStringContainsString('Label width must be between 1 and 12', $exception->getMessage());
    }

    public static function labelWidthEdgeCasesProvider(): array
    {
        return [
            'PHP_INT_MIN' => [PHP_INT_MIN],
            'PHP_INT_MAX' => [PHP_INT_MAX],
            'zero'        => [0],
            'negative'    => [-999],
            'positive'    => [999],
        ];
    }

    public function test_exception_message_format_is_consistent(): void
    {
        $exception = InvalidColumns::forLabel(99);

        // Check the message follows the expected pattern
        $this->assertMatchesRegularExpression(
            '/^Label width \d+ is invalid\. Label width must be between 1 and 12\.$/',
            $exception->getMessage(),
        );
    }

    public function test_it_preserves_label_width_in_message_for_negative_values(): void
    {
        $exception = InvalidColumns::forLabel(-5);

        $this->assertStringContainsString('-5', $exception->getMessage());
        $this->assertSame(
            'Label width -5 is invalid. Label width must be between 1 and 12.',
            $exception->getMessage(),
        );
    }

    public function test_it_preserves_label_width_in_message_for_large_values(): void
    {
        $exception = InvalidColumns::forLabel(999);

        $this->assertStringContainsString('999', $exception->getMessage());
        $this->assertSame(
            'Label width 999 is invalid. Label width must be between 1 and 12.',
            $exception->getMessage(),
        );
    }
}
