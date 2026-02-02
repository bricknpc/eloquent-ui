<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Input\Addon;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class BtnTest extends TestCase
{
    use InteractsWithViews;

    public function test_it_creates_an_addon_button(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.btn id="my-addon" />');

        $view->assertSee('<button', false);
        $view->assertSee('id="my-addon"', false);
        $view->assertSee('type="button"', false);
        $view->assertSee('role="button"', false);
    }

    public function test_it_merges_custom_css_classes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.btn id="my-addon" class="custom-class" />');

        $view->assertSee('class="input-group-text btn btn-secondary custom-class"', false);
    }

    public function test_it_uses_style_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.btn id="my-addon" style="primary" />');

        $view->assertSee('class="input-group-text btn btn-primary"', false);
    }

    public function test_it_uses_style_from_config_if_no_style_is_provided(): void
    {
        config()->set('eloquent-ui.input.addon-button-style', 'warning');

        $view = $this->blade('<x-eloquent-ui::input.addon.btn id="my-addon" />');

        $view->assertSee('class="input-group-text btn btn-warning"', false);
    }
}
