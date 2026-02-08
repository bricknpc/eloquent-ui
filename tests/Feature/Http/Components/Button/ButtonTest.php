<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Button;

use PHPUnit\Framework\Attributes\Test;
use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class ButtonTest extends TestCase
{
    use InteractsWithViews;

    #[Test]
    public function it_renders_basic_button_with_default_props(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="test-button">Click Me</x-eloquent-ui::button>',
        );

        $view->assertSee('Click Me', false);
        $view->assertSee('type="button"', false);
        $view->assertSee('name="test-button"', false);
        $view->assertSee('id="test-button"', false);
        $view->assertSee('class="btn btn-primary"', false);
    }

    #[Test]
    public function it_renders_submit_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="submit-btn" type="submit">Submit</x-eloquent-ui::button>',
        );

        $view->assertSee('type="submit"', false);
    }

    #[Test]
    public function it_applies_different_themes(): void
    {
        $themes = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($themes as $theme) {
            $view = $this->blade(
                '<x-eloquent-ui::button name="btn" theme="' . $theme . '">Button</x-eloquent-ui::button>',
            );

            $view->assertSee('btn-' . $theme, false);
        }
    }

    #[Test]
    public function it_applies_no_wrap_class(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :noWrap="true">No Wrap</x-eloquent-ui::button>',
        );

        $view->assertSee('text-nowrap', false);
    }

    #[Test]
    public function it_does_not_apply_no_wrap_class_by_default(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn">Wrap</x-eloquent-ui::button>',
        );

        $view->assertDontSee('text-nowrap', false);
    }

    #[Test]
    public function it_renders_disabled_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :disabled="true">Disabled</x-eloquent-ui::button>',
        );

        $view->assertSee('disabled', false);
        $view->assertSee('aria-disabled="true"', false);
    }

    #[Test]
    public function it_renders_readonly_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :readonly="true">Readonly</x-eloquent-ui::button>',
        );

        $view->assertSee('readonly', false);
        $view->assertSee('aria-readonly="true"', false);
    }

    #[Test]
    public function it_renders_toggle_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :toggle="true">Toggle</x-eloquent-ui::button>',
        );

        $view->assertSee('data-bs-toggle="button"', false);
    }

    #[Test]
    public function it_renders_pressed_toggle_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :toggle="true" :pressed="true">Pressed</x-eloquent-ui::button>',
        );

        $view->assertSee('data-bs-toggle="button"', false);
        $view->assertSee('aria-pressed="true"', false);
        $view->assertSee('active', false);
    }

    #[Test]
    public function it_does_not_apply_pressed_state_without_toggle(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :pressed="true">Not Toggle</x-eloquent-ui::button>',
        );

        $view->assertDontSee('aria-pressed', false);
        $view->assertDontSee('data-bs-toggle', false);
    }

    #[Test]
    public function it_renders_with_offset_wrapper(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" offset="3">Offset Button</x-eloquent-ui::button>',
        );

        $view->assertSee('<div class="row">', false);
        $view->assertSee('<div class="offset-sm-3">', false);
        $view->assertSee('Offset Button', false);
        $view->assertSee('</div>', false);
    }

    #[Test]
    public function it_does_not_render_offset_wrapper_by_default(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn">No Offset</x-eloquent-ui::button>',
        );

        $view->assertDontSee('class="row"', false);
        $view->assertDontSee('offset-sm-', false);
    }

    #[Test]
    public function it_applies_once_data_attribute(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :once="true">Once</x-eloquent-ui::button>',
        );

        $view->assertSeeInOrder(['data-', '-once="true"'], false);
    }

    #[Test]
    public function it_does_not_apply_once_attribute_by_default(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn">Normal</x-eloquent-ui::button>',
        );

        $view->assertDontSee('-once=', false);
    }

    #[Test]
    public function it_merges_additional_attributes(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" class="custom-class" data-test="value">Custom</x-eloquent-ui::button>',
        );

        $view->assertSee('custom-class', false);
        $view->assertSee('data-test="value"', false);
        $view->assertSee('btn btn-primary', false);
    }

    #[Test]
    public function it_handles_multiple_states_simultaneously(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button 
                name="complex-btn" 
                type="submit"
                theme="danger"
                :noWrap="true"
                :disabled="true"
                :toggle="true"
                :pressed="true"
                :once="true"
                offset="2"
            >Complex Button</x-eloquent-ui::button>',
        );

        $view->assertSee('type="submit"', false);
        $view->assertSee('btn-danger', false);
        $view->assertSee('text-nowrap', false);
        $view->assertSee('disabled', false);
        $view->assertSee('aria-disabled="true"', false);
        $view->assertSee('data-bs-toggle="button"', false);
        $view->assertSee('aria-pressed="true"', false);
        $view->assertSee('active', false);
        $view->assertSeeInOrder(['data-', '-once="true"'], false);
        $view->assertSee('offset-sm-2', false);
        $view->assertSee('Complex Button', false);
    }

    #[Test]
    public function it_renders_with_html_in_slot(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn"><strong>Bold</strong> Text</x-eloquent-ui::button>',
        );

        $view->assertSee('<strong>Bold</strong> Text', false);
    }

    #[Test]
    public function it_handles_different_offset_values(): void
    {
        foreach (range(0, 11) as $offset) {
            $view = $this->blade(
                '<x-eloquent-ui::button name="btn" offset="' . $offset . '">Button</x-eloquent-ui::button>',
            );

            $view->assertSee('offset-sm-' . $offset, false);
        }
    }

    #[Test]
    public function it_does_not_render_disabled_attributes_when_false(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :disabled="false">Enabled</x-eloquent-ui::button>',
        );

        $view->assertDontSee('disabled', false);
        $view->assertDontSee('aria-disabled', false);
    }

    #[Test]
    public function it_does_not_render_readonly_attributes_when_false(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button name="btn" :readonly="false">Not Readonly</x-eloquent-ui::button>',
        );

        $view->assertDontSee('readonly', false);
        $view->assertDontSee('aria-readonly', false);
    }

    // Alias Tests

    #[Test]
    #[DataProvider('themeAliasProvider')]
    public function it_renders_theme_alias_buttons(string $theme, string $expectedClass): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button.' . $theme . ' name="btn">Button</x-eloquent-ui::button.' . $theme . '>',
        );

        $view->assertSee('btn-' . $expectedClass, false);
        $view->assertSee('type="button"', false);
    }

    public static function themeAliasProvider(): array
    {
        return [
            'primary'             => ['primary', 'primary'],
            'secondary'           => ['secondary', 'secondary'],
            'tertiary'            => ['tertiary', 'tertiary'],
            'success'             => ['success', 'success'],
            'danger'              => ['danger', 'danger'],
            'warning'             => ['warning', 'warning'],
            'error'               => ['error', 'danger'],
            'info'                => ['info', 'info'],
            'light'               => ['light', 'light'],
            'dark'                => ['dark', 'dark'],
            'outline-primary'     => ['outline-primary', 'outline-primary'],
            'outline-secondary'   => ['outline-secondary', 'outline-secondary'],
            'outline-tertiary'    => ['outline-tertiary', 'outline-tertiary'],
            'outline-success'     => ['outline-success', 'outline-success'],
            'outline-danger'      => ['outline-danger', 'outline-danger'],
            'outline-warning'     => ['outline-warning', 'outline-warning'],
            'outline-error'       => ['outline-error', 'outline-danger'],
            'outline-info'        => ['outline-info', 'outline-info'],
            'outline-light'       => ['outline-light', 'outline-light'],
            'outline-dark'        => ['outline-dark', 'outline-dark'],
        ];
    }

    #[Test]
    public function it_renders_submit_alias_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button.submit name="btn">Submit</x-eloquent-ui::button.submit>',
        );

        $view->assertSee('type="submit"', false);
    }

    #[Test]
    public function it_renders_reset_alias_button(): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button.reset name="btn">Reset</x-eloquent-ui::button.reset>',
        );

        $view->assertSee('type="reset"', false);
    }

    #[Test]
    #[DataProvider('submitThemeAliasProvider')]
    public function it_renders_submit_with_theme_alias_buttons(string $theme, string $expectedClass): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button.submit.' . $theme . ' name="btn">Submit</x-eloquent-ui::button.submit.' . $theme . '>',
        );

        $view->assertSee('type="submit"', false);
        $view->assertSee('btn-' . $expectedClass, false);
    }

    public static function submitThemeAliasProvider(): array
    {
        return self::themeAliasProvider();
    }

    #[Test]
    #[DataProvider('resetThemeAliasProvider')]
    public function it_renders_reset_with_theme_alias_buttons(string $theme, string $expectedClass): void
    {
        $view = $this->blade(
            '<x-eloquent-ui::button.reset.' . $theme . ' name="btn">Reset</x-eloquent-ui::button.reset.' . $theme . '>',
        );

        $view->assertSee('type="reset"', false);
        $view->assertSee('btn-' . $expectedClass, false);
    }

    public static function resetThemeAliasProvider(): array
    {
        return self::themeAliasProvider();
    }
}
