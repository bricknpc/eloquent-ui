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
}
