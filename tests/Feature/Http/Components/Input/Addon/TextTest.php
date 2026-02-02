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
class TextTest extends TestCase
{
    use InteractsWithViews;

    public function test_it_creates_an_addon_button(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.text id="my-addon" />');

        $view->assertSee('<span', false);
        $view->assertSee('id="my-addon"', false);
    }

    public function test_it_merges_custom_css_classes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.text id="my-addon" class="custom-class" />');

        $view->assertSee('class="input-group-text bg-secondary custom-class"', false);
    }

    public function test_it_uses_style_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.addon.text id="my-addon" style="primary" />');

        $view->assertSee('class="input-group-text bg-primary"', false);
    }

    public function test_it_uses_style_from_config_if_no_style_is_provided(): void
    {
        config()->set('eloquent-ui.input.addon-style', 'warning');

        $view = $this->blade('<x-eloquent-ui::input.addon.text id="my-addon" />');

        $view->assertSee('class="input-group-text bg-warning"', false);
    }
}
