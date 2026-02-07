<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Form;

use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\LabelPosition;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class RowTest extends TestCase
{
    use InteractsWithViews;

    public function test_it_renders_a_row_with_label(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" />');

        $view->assertSee('row', false);
        $view->assertSee('<label', false);
        $view->assertSee('for="test"', false);
        $view->assertSee('id="test-label"', false);
        $view->assertSeeText('Test');
    }

    public function test_it_renders_a_row_with_custom_id(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" id="my-id" />');

        $view->assertSee('row', false);
        $view->assertSee('<label', false);
        $view->assertSee('for="test"', false);
        $view->assertSee('id="my-id"', false);
        $view->assertSeeText('Test');
    }

    public function test_it_renders_a_row_with_custom_label(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" label="My custom label" />');

        $view->assertSee('row', false);
        $view->assertSee('<label', false);
        $view->assertSee('for="test"', false);
        $view->assertSeeText('My custom label');
    }

    public function test_it_renders_visual_and_accessibility_indicators_when_required(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" required />');

        $view->assertSee('class="text-danger"', false);
        $view->assertSee('aria-hidden="true"', false);
        $view->assertSee('class="visually-hidden"', false);
        $view->assertSeeText('*');
    }

    public function test_it_renders_uses_custom_required_theme(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" required required-style="warning" />');

        $view->assertSee('class="text-warning"', false);
    }

    public function test_it_renders_required_theme_from_config(): void
    {
        config()->set('eloquent-ui.input.required-style', 'dark');

        $view = $this->blade('<x-eloquent-ui::form.row for="test" required />');

        $view->assertSee('class="text-dark"', false);
    }

    public function test_it_renders_uses_custom_required_icon(): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" required required-icon="!!!" />');

        $view->assertSeeText('!!!', false);
    }

    public function test_it_renders_required_icon_from_config(): void
    {
        config()->set('eloquent-ui.input.required-icon', '!%!');

        $view = $this->blade('<x-eloquent-ui::form.row for="test" required />');

        $view->assertSeeText('!%!', false);
    }

    #[DataProvider('labelPositionProvider')]
    public function test_it_renders_label_position_correctly(LabelPosition $position): void
    {
        $view = $this->blade('<x-eloquent-ui::form.row for="test" :label-position="$position" />', [
            'position' => $position,
        ]);

        $view->assertSee($position->getInputClasses(), false);
        $view->assertSee($position->getLabelClasses(), false);
    }

    public static function labelPositionProvider(): \Generator
    {
        foreach (LabelPosition::cases() as $position) {
            yield [$position];
        }
    }

    public function test_it_renders_label_position_from_config(): void
    {
        config()->set('eloquent-ui.input.position', LabelPosition::Bottom);

        $view = $this->blade('<x-eloquent-ui::form.row for="test" />');

        $view->assertSee(LabelPosition::Bottom->getInputClasses(), false);
        $view->assertSee(LabelPosition::Bottom->getLabelClasses(), false);
    }
}
