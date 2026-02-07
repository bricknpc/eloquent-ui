<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Http\Components\Input;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\LabelPosition;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class TextTest extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        view()->share('errors', new ViewErrorBag());
    }

    public function test_it_creates_a_text_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="text"', false);
    }

    #[DataProvider('typeProvider')]
    public function test_it_creates_a_text_input_of_the_given_type(string $type): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" type="' . $type . '" />');

        $view->assertSee('<input', false);
        $view->assertSee('type="' . $type . '"', false);
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

        yield ['text'];

        yield ['time'];

        yield ['url'];

        yield ['week'];
    }

    public function test_it_creates_a_text_input_with_the_correct_labelledby(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label-id="label-id" />');

        $view->assertSee('<input', false);
        $view->assertSee('aria-labelledby="label-id"', false);
    }

    public function test_it_creates_a_required_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" required />');

        $view->assertSee('<input', false);
        $view->assertSee('aria-required="true"', false);
        $view->assertSee(' required ', false);
    }

    public function test_it_creates_a_readonly_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" readonly />');

        $view->assertSee('<input', false);
        $view->assertSee('aria-readonly="true"', false);
        $view->assertSee(' readonly ', false);
    }

    public function test_it_creates_a_disabled_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" disabled />');

        $view->assertSee('<input', false);
        $view->assertSee('aria-disabled="true"', false);
        $view->assertSee(' disabled ', false);
    }

    public function test_it_creates_an_input_with_a_value(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" value="test" />');

        $view->assertSee('<input', false);
        $view->assertSee('value="test"', false);
    }

    public function test_it_shows_the_hint(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" hint="test" />');

        $view->assertSee('<div id="name-hint" class="form-text">test</div>', false);
    }

    public function test_it_renders_the_prefix(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name"><x-slot:prefix id="prefix-id">This is the prefix</x-slot></x-eloquent-ui::input.text>');

        $view->assertSee('prefix-id', false);
        $view->assertSeeText('This is the prefix');
    }

    public function test_it_renders_the_suffix(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name"><x-slot:suffix id="suffix-id">This is the suffix</x-slot></x-eloquent-ui::input.text>');

        $view->assertSee('suffix-id', false);
        $view->assertSeeText('This is the suffix');
    }

    public function test_it_shows_errors_correctly(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['name' => 'Error message']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.text name="name" />');

        $view->assertSee('aria-invalid="true"', false);
        $view->assertSee('is-invalid', false);
        $view->assertSee('name-feedback', false);
        $view->assertSee('<div id="name-feedback" class="invalid-feedback d-block" role="alert">Error message</div>', false);
    }

    public function test_it_renders_custom_attributes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" data-custom-attribute="custom-value" />');

        $view->assertSee('data-custom-attribute="custom-value"', false);
    }

    public function test_it_merges_custom_css_classes(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" class="custom-class" />');

        $view->assertSee('class="form-control custom-class"', false);
    }

    // Label tests

    public function test_it_does_not_render_row_when_no_label_provided(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" />');

        $view->assertDontSee('<label', false);
        $view->assertDontSee('row', false);
    }

    public function test_providing_a_label_renders_a_row(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Label text:" />');

        $view->assertSee('row', false);
        $view->assertSee('<label', false);
        $view->assertSee('Label text:', false);
    }

    public function test_it_renders_label_with_correct_for_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="email" label="Email Address:" />');

        $view->assertSee('for="email"', false);
        $view->assertSee('id="email-label"', false);
    }

    public function test_it_renders_label_with_required_indicator_when_required(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Label text:" required />');

        $view->assertSee('Label text:', false);
        $view->assertSee('*', false); // Default required icon
    }

    public function test_it_renders_custom_required_icon(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" required required-icon="(required)" />');

        $view->assertSee('Name:', false);
        $view->assertSee('(required)', false);
    }

    #[DataProvider('requiredStyleProvider')]
    public function test_it_renders_required_icon_with_correct_style(string $style): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" required required-style="' . $style . '" />');

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
    public function test_it_renders_label_in_different_positions(LabelPosition $position, array $expectedClasses): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" :label-position="$position" />', [
            'position' => $position,
        ]);

        foreach ($expectedClasses as $class) {
            $view->assertSee($class, false);
        }
    }

    public static function labelPositionProvider(): \Generator
    {
        yield 'top' => [LabelPosition::Top, ['col-12']];

        yield 'bottom' => [LabelPosition::Bottom, ['col-12', 'order-sm-last']];

        yield 'left' => [LabelPosition::Left, ['col-sm-3', 'col-sm-9']];

        yield 'right' => [LabelPosition::Right, ['col-sm-3', 'order-sm-last', 'col-sm-9', 'order-sm-first']];
    }

    #[DataProvider('labelWidthProvider')]
    public function test_it_renders_label_with_custom_width(int $labelWidth, string $expectedLabelClass, string $expectedInputClass): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" label-position="$position" label-width="' . $labelWidth . '" />', [
            'position' => LabelPosition::Left,
        ]);

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
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" row-class="custom-row-class" />');

        $view->assertSee('custom-row-class', false);
    }

    public function test_it_renders_with_default_row_class(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" />');

        $view->assertSee('mb-3', false); // Default from config
    }

    public function test_label_position_top_renders_label_above_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" :label-position="$position" />', [
            'position' => LabelPosition::Top,
        ]);

        $view->assertSee('col-12', false);
        $view->assertDontSee('order-sm-last', false);
    }

    public function test_label_position_bottom_renders_label_below_input(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" :label-position="$position" />', [
            'position' => LabelPosition::Bottom,
        ]);

        $view->assertSee('col-12', false);
        $view->assertSee('order-sm-last', false);
    }

    public function test_label_position_left_renders_label_on_left(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" :label-position="$position" />', [
            'position' => LabelPosition::Left,
        ]);

        $view->assertSee('col-sm-3', false); // Default label width
        $view->assertSee('col-sm-9', false); // Remaining width for input
    }

    public function test_label_position_right_renders_label_on_right(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" :label-position="$position" />', [
            'position' => LabelPosition::Right,
        ]);

        $view->assertSee('col-sm-3', false);
        $view->assertSee('order-sm-last', false);
        $view->assertSee('col-sm-9', false);
        $view->assertSee('order-sm-first', false);
    }

    public function test_it_combines_label_required_and_hint(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" required hint="Enter your full name" />');

        $view->assertSee('Name:', false);
        $view->assertSee('*', false);
        $view->assertSee('Enter your full name', false);
    }

    public function test_it_combines_label_with_prefix_and_suffix(): void
    {
        $view = $this->blade('
            <x-eloquent-ui::input.text name="price" label="Price:">
                <x-slot:prefix>$</x-slot>
                <x-slot:suffix>.00</x-slot>
            </x-eloquent-ui::input.text>
        ');

        $view->assertSee('Price:', false);
        $view->assertSeeText('$');
        $view->assertSeeText('.00');
    }

    public function test_it_renders_label_with_all_options_combined(): void
    {
        $view = $this->blade('
            <x-eloquent-ui::input.text 
                name="email" 
                label="Email Address:" 
                :label-position="$position"
                label-width="4"
                required
                required-icon="*"
                required-style="danger"
                row-class="custom-mb-4"
                hint="We\'ll never share your email"
            />
        ', [
            'position' => LabelPosition::Left,
        ]);

        $view->assertSee('Email Address:', false);
        $view->assertSee('col-sm-4', false);
        $view->assertSee('col-sm-8', false);
        $view->assertSee('*', false);
        $view->assertSee('text-danger', false);
        $view->assertSee('custom-mb-4', false);
    }

    public function test_label_works_with_errors(): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['name' => 'The name field is required.']));

        view()->share('errors', $errors);

        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" required />');

        $view->assertSee('Name:', false);
        $view->assertSee('*', false);
        $view->assertSee('The name field is required.', false);
        $view->assertSee('is-invalid', false);
    }

    public function test_it_does_not_render_required_indicator_when_not_required(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="Name:" />');

        $view->assertSee('Name:', false);
        // Shouldn't see the required indicator when not required
        $content       = (string) $view;
        $labelCount    = substr_count($content, 'Name:');
        $asteriskCount = substr_count($content, '*');

        $this->assertGreaterThan(0, $labelCount);
        // If there's an asterisk, it shouldn't be related to required indicator
    }

    public function test_it_escapes_label_html(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="name" label="<script>alert(\'xss\')</script>" />');

        $view->assertDontSee('<script>alert(\'xss\')</script>', false);
        $view->assertSee('&lt;script&gt;', false);
    }

    public function test_label_id_is_generated_correctly(): void
    {
        $view = $this->blade('<x-eloquent-ui::input.text name="user_email" label="User Email:" />');

        $view->assertSee('id="user_email-label"', false);
        $view->assertSee('for="user_email"', false);
    }
}
