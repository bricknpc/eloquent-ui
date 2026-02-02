<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Input;

use function BrickNPC\EloquentUI\ns;

use Illuminate\Support\ViewErrorBag;
use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class PasswordTest extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        view()->share('errors', new ViewErrorBag());
    }

    public function test_it_uses_allow_type_switch_from_config(): void
    {
        config()->set('eloquent-ui.input.password.allow-type-switch', false);

        $view = $this->blade('<x-eloquent-ui::input.password name="name" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="password"', false);
        $view->assertSee('data-' . ns() . '-password-allow-switch="false"', false);
    }

    public function test_it_sets_allow_type_switch(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.password name="name" allow-type-switch="false" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="password"', false);
        $view->assertSee('data-' . ns() . '-password-allow-switch="false"', false);
    }

    public function test_it_uses_switch_icon_from_config(): void
    {
        config()->set('eloquent-ui.input.password.switch-icon', 'O');

        $view = $this->blade('<x-eloquent-ui::input.password name="name" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="password"', false);
        $view->assertSee('data-' . ns() . '-password-switch-icon="O"', false);
    }

    public function test_it_sets_switch_icon(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.password name="name" switch-icon="+" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="password"', false);
        $view->assertSee('data-' . ns() . '-password-switch-icon="+"', false);
    }
}
