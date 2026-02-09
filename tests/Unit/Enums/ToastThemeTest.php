<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Enums;

use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\ToastTheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesFunction;

/**
 * @internal
 */
#[CoversClass(ToastTheme::class)]
#[UsesFunction('BrickNPC\EloquentUI\__')]
class ToastThemeTest extends TestCase
{
    #[DataProvider('toastThemeCssClassProvider')]
    public function test_it_returns_the_correct_css_class(ToastTheme $theme, string $expectedCssClass): void
    {
        $this->assertSame($expectedCssClass, $theme->getCssClass());
    }

    public static function toastThemeCssClassProvider(): \Generator
    {
        yield [ToastTheme::Success, 'success'];

        yield [ToastTheme::Warning, 'warning'];

        yield [ToastTheme::Danger, 'danger'];

        yield [ToastTheme::Info, 'info'];
    }

    #[DataProvider('toastThemeTitleProvider')]
    public function test_it_returns_the_correct_title(ToastTheme $theme, string $expectedTitle): void
    {
        $this->assertSame($expectedTitle, $theme->getTitle());
    }

    public static function toastThemeTitleProvider(): \Generator
    {
        yield [ToastTheme::Success, 'Success'];

        yield [ToastTheme::Warning, 'Warning'];

        yield [ToastTheme::Danger, 'Error'];

        yield [ToastTheme::Info, 'Info'];
    }
}
