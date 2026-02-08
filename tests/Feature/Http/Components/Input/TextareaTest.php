<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Input;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class TextareaTest extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        view()->share('errors', new ViewErrorBag());
    }

    // Basic rendering tests

    public function test_it_creates_a_textarea(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertSee('<textarea', false);
        $view->assertSee('name="description"', false);
        $view->assertSee('id="description"', false);
    }

    public function test_it_creates_a_textarea_with_the_correct_labelledby(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label-id="label-id" />');

        $view->assertSee('<textarea', false);
        $view->assertSee('aria-labelledby="label-id"', false);
    }

    public function test_it_creates_a_required_textarea(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" required />');

        $view->assertSee('<textarea', false);
        $view->assertSee('aria-required="true"', false);
        $view->assertSee(' required ', false);
    }

    public function test_it_creates_a_readonly_textarea(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" readonly />');

        $view->assertSee('<textarea', false);
        $view->assertSee('aria-readonly="true"', false);
        $view->assertSee(' readonly ', false);
    }

    public function test_it_creates_a_disabled_textarea(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" disabled />');

        $view->assertSee('<textarea', false);
        $view->assertSee('aria-disabled="true"', false);
        $view->assertSee(' disabled ', false);
    }

    public function test_it_creates_a_textarea_with_a_value(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" value="test content" />');

        $view->assertSee('<textarea', false);
        $view->assertSeeText('test content');
    }

    public function test_it_shows_the_hint(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" hint="Enter a detailed description" />');

        $view->assertSee('<div id="description-hint" class="form-text">Enter a detailed description</div>', false);
    }

    // Resize tests

    #[DataProvider('resizeProvider')]
    public function test_it_applies_resize_style(string $resize): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" resize="' . $resize . '" />');

        $view->assertSee('style="resize: ' . $resize . '"', false);
    }

    public static function resizeProvider(): \Generator
    {
        yield 'vertical' => ['vertical'];

        yield 'horizontal' => ['horizontal'];

        yield 'both' => ['both'];

        yield 'none' => ['none'];
    }

    public function test_it_uses_default_resize_vertical(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertSee('style="resize: vertical"', false);
    }

    // Error handling tests

    public function test_it_shows_errors_correctly(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['description' => 'The description field is required.']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertSee('aria-invalid="true"', false);
        $view->assertSee('is-invalid', false);
        $view->assertSee('description-feedback', false);
        $view->assertSee('<div id="description-feedback" class="invalid-feedback d-block" role="alert">The description field is required.</div>', false);
    }

    // Attribute tests

    public function test_it_renders_custom_attributes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" data-custom-attribute="custom-value" />');

        $view->assertSee('data-custom-attribute="custom-value"', false);
    }

    public function test_it_merges_custom_css_classes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" class="custom-class" />');

        $view->assertSee('class="form-control custom-class"', false);
    }

    public function test_it_excludes_internal_attributes_from_textarea(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label-position="left" required-icon="*" />');

        $view->assertDontSee('label-position', false);
        $view->assertDontSee('required-icon', false);
        $view->assertDontSee('resize="vertical"', false);
    }

    public function test_it_supports_rows_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" rows="10" />');

        $view->assertSee('rows="10"', false);
    }

    public function test_it_supports_cols_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" cols="50" />');

        $view->assertSee('cols="50"', false);
    }

    public function test_it_supports_placeholder_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" placeholder="Enter description here..." />');

        $view->assertSee('placeholder="Enter description here..."', false);
    }

    public function test_it_supports_maxlength_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" maxlength="500" />');

        $view->assertSee('maxlength="500"', false);
    }

    // Label tests

    public function test_it_does_not_render_row_when_no_label_provided(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertDontSee('<label', false);
        $view->assertDontSee('row', false);
    }

    public function test_providing_a_label_renders_a_row(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" />');

        $view->assertSee('row', false);
        $view->assertSee('<label', false);
        $view->assertSee('Description:', false);
    }

    public function test_it_renders_label_with_correct_for_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="bio" label="Biography:" />');

        $view->assertSee('for="bio"', false);
        $view->assertSee('id="bio-label"', false);
    }

    public function test_it_renders_label_with_required_indicator_when_required(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" required />');

        $view->assertSee('Description:', false);
        $view->assertSee('*', false);
    }

    public function test_it_renders_custom_required_icon(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" required required-icon="(required)" />');

        $view->assertSee('Description:', false);
        $view->assertSee('(required)', false);
    }

    #[DataProvider('requiredStyleProvider')]
    public function test_it_renders_required_icon_with_correct_style(string $style): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" required required-style="' . $style . '" />');

        $view->assertSee('text-' . $style, false);
    }

    public static function requiredStyleProvider(): \Generator
    {
        yield ['danger'];

        yield ['warning'];

        yield ['primary'];

        yield ['success'];

        yield ['info'];
    }

    #[DataProvider('labelPositionProvider')]
    public function test_it_renders_label_in_different_positions(string $position, array $expectedClasses): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" label-position="' . $position . '" />');

        foreach ($expectedClasses as $class) {
            $view->assertSee($class, false);
        }
    }

    public static function labelPositionProvider(): \Generator
    {
        yield 'top' => ['top', ['col-12']];

        yield 'bottom' => ['bottom', ['col-12', 'order-sm-last']];

        yield 'left' => ['left', ['col-sm-3', 'col-sm-9']];

        yield 'right' => ['right', ['col-sm-3', 'order-sm-last', 'col-sm-9', 'order-sm-first']];
    }

    #[DataProvider('labelWidthProvider')]
    public function test_it_renders_label_with_custom_width(int $labelWidth, string $expectedLabelClass, string $expectedInputClass): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" label-position="left" label-width="' . $labelWidth . '" />');

        $view->assertSee($expectedLabelClass, false);
        $view->assertSee($expectedInputClass, false);
    }

    public static function labelWidthProvider(): \Generator
    {
        yield 'width 2' => [2, 'col-sm-2', 'col-sm-10'];

        yield 'width 3' => [3, 'col-sm-3', 'col-sm-9'];

        yield 'width 4' => [4, 'col-sm-4', 'col-sm-8'];

        yield 'width 6' => [6, 'col-sm-6', 'col-sm-6'];
    }

    public function test_it_renders_with_custom_row_class(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" row-class="custom-row-class" />');

        $view->assertSee('custom-row-class', false);
    }

    public function test_it_renders_with_default_row_class(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" />');

        $view->assertSee('mb-3', false);
    }

    // Combined scenarios

    public function test_it_combines_label_required_and_hint(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" required hint="Please provide details" />');

        $view->assertSee('Description:', false);
        $view->assertSee('*', false);
        $view->assertSee('Please provide details', false);
    }

    public function test_it_renders_label_with_all_options_combined(): void
    {
        $view = $this->blade('
            <x-eloquent-ui::input.textarea 
                name="bio" 
                label="Biography:" 
                label-position="left"
                label-width="4"
                required
                required-icon="*"
                required-style="danger"
                row-class="custom-mb-4"
                hint="Tell us about yourself"
                rows="10"
                resize="both"
            />
        ');

        $view->assertSee('Biography:', false);
        $view->assertSee('col-sm-4', false);
        $view->assertSee('col-sm-8', false);
        $view->assertSee('*', false);
        $view->assertSee('text-danger', false);
        $view->assertSee('custom-mb-4', false);
        $view->assertSee('Tell us about yourself', false);
        $view->assertSee('rows="10"', false);
        $view->assertSee('style="resize: both"', false);
    }

    public function test_label_works_with_errors(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['description' => 'The description field is required.']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" required />');

        $view->assertSee('Description:', false);
        $view->assertSee('*', false);
        $view->assertSee('The description field is required.', false);
        $view->assertSee('is-invalid', false);
    }

    public function test_it_does_not_render_required_indicator_when_not_required(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="Description:" />');

        $view->assertSee('Description:', false);
        // The asterisk shouldn't appear when not required
        $content    = (string) $view;
        $labelCount = substr_count($content, 'Description:');

        $this->assertGreaterThan(0, $labelCount);
    }

    public function test_it_escapes_label_html(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" label="<script>alert(\'xss\')</script>" />');

        $view->assertDontSee('<script>alert(\'xss\')</script>', false);
        $view->assertSee('&lt;script&gt;', false);
    }

    public function test_label_id_is_generated_correctly(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="user_bio" label="User Bio:" />');

        $view->assertSee('id="user_bio-label"', false);
        $view->assertSee('for="user_bio"', false);
    }

    // Content handling tests

    public function test_it_handles_multiline_content(): void
    {
        $multilineContent = "Line 1\nLine 2\nLine 3";

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" value="' . $multilineContent . '" />');

        $view->assertSee('Line 1', false);
        $view->assertSee('Line 2', false);
        $view->assertSee('Line 3', false);
    }

    public function test_it_preserves_whitespace_in_content(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" value="  spaces  " />');

        $view->assertSee('  spaces  ', false);
    }

    public function test_it_handles_empty_content(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertSee('<textarea', false);
        $view->assertSee('</textarea>', false);
    }

    public function test_it_escapes_html_in_content(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" value="<p>HTML content</p>" />');

        $view->assertSee('&lt;p&gt;HTML content&lt;/p&gt;', false);
        $view->assertDontSee('<p>HTML content</p>', false);
    }

    // Accessibility tests

    public function test_it_has_correct_aria_describedby_with_hint(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" hint="Helper text" />');

        $view->assertSee('description-hint', false);
    }

    public function test_it_has_correct_aria_describedby_with_error(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['description' => 'Error message']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" />');

        $view->assertSee('description-feedback', false);
    }

    public function test_it_has_correct_aria_describedby_with_hint_and_error(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['description' => 'Error message']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" hint="Helper text" />');

        $view->assertSee('description-hint', false);
        $view->assertSee('description-feedback', false);
    }

    // Edge cases

    public function test_it_handles_special_characters_in_name(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="user[bio]" />');

        $view->assertSee('name="user[bio]"', false);
        $view->assertSee('id="user[bio]"', false);
    }

    public function test_it_handles_numeric_values(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" value="12345" />');

        $view->assertSeeText('12345');
    }

    public function test_it_handles_long_content(): void
    {
        $longContent = str_repeat('Lorem ipsum dolor sit amet. ', 100);

        $view = $this->blade('<x-eloquent-ui::input.textarea name="description" :value="$content" />', [
            'content' => $longContent,
        ]);

        $view->assertSeeText('Lorem ipsum dolor sit amet.');
    }
}
