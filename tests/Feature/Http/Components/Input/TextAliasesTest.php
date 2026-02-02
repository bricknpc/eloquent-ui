<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Input;

use Illuminate\Support\ViewErrorBag;
use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class TextAliasesTest extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        view()->share('errors', new ViewErrorBag());
    }

    #[DataProvider('typeProvider')]
    public function test_it_creates_a_text_input_with_the_correct_type_through_the_alias_component(string $type): void
    {
        $view = $this->blade('<x-eloquent-ui::input.' . $type . ' name="name" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="' . $type . '"', false);
        $view->assertSee('name="name"', false);
    }

    public static function typeProvider(): \Generator
    {
        yield ['color'];

        yield ['date'];

        yield ['datetime-local'];

        yield ['email'];

        yield ['month'];

        yield ['number'];

        yield ['password'];

        yield ['search'];

        yield ['tel'];

        yield ['time'];

        yield ['url'];

        yield ['week'];
    }
}
