<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Enums;

use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\ToastLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @internal
 */
#[CoversClass(ToastLocation::class)]
class ToastLocationTest extends TestCase
{
    #[DataProvider('toastLocationCssClassProvider')]
    public function test_it_returns_the_correct_css_class(ToastLocation $location, string $expectedCssClass): void
    {
        $this->assertSame($expectedCssClass, $location->getCssClass());
    }

    public static function toastLocationCssClassProvider(): \Generator
    {
        yield [ToastLocation::TopLeft, 'position-fixed toast-container top-0 start-0'];

        yield [ToastLocation::TopRight, 'position-fixed toast-container top-0 end-0'];

        yield [ToastLocation::BottomLeft, 'position-fixed toast-container bottom-0 start-0'];

        yield [ToastLocation::BottomRight, 'position-fixed toast-container bottom-0 end-0'];

        yield [ToastLocation::TopCenter, 'position-fixed toast-container top-0 start-50 translate-middle-x'];

        yield [ToastLocation::BottomCenter, 'position-fixed toast-container bottom-0 start-50 translate-middle-x'];

        yield [ToastLocation::LeftMiddle, 'position-fixed toast-container top-50 start-0 translate-middle-y'];

        yield [ToastLocation::RightMiddle, 'position-fixed toast-container top-50 end-0 translate-middle-y'];
    }
}
