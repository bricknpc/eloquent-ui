<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Feature\Components;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

/**
 * @internal
 */
#[CoversNothing]
class FormTest extends TestCase
{
    use InteractsWithViews;

    public function test_it_creates_a_form(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" />');

        $view->assertSee('<form', false);
        $view->assertSee('action="/"', false);
        $view->assertSee('method="post"', false);
        $view->assertSee('name="_token"', false);
    }

    #[DataProvider('methodProvider')]
    public function test_it_creates_a_form_with_custom_method(string $method): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" method="' . $method . '" />');

        $view->assertSee('method="post"', false);
        $view->assertSee('name="_method"', false);
        $view->assertSee('value="' . strtoupper($method) . '"', false);
    }

    public static function methodProvider(): \Generator
    {
        yield ['put'];

        yield ['patch'];

        yield ['delete'];
    }

    public function test_get_forms_do_not_add_the_csrf_token(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" method="get" />');

        $view->assertDontSee('name="_token"', false);
    }

    public function test_forcing_csrf_token_adds_the_csrf_token_to_get_forms(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" method="get" force-csrf />');

        $view->assertSee('name="_token"', false);
    }

    public function test_setting_files_to_true_adds_the_enctype_multipart_form_data(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" files />');

        $view->assertSee('enctype="multipart/form-data"', false);
    }

    public function test_adding_novalidate_adds_the_novalidate_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" novalidate />');

        $view->assertSee('novalidate', false);
    }

    public function test_adding_autocomplete_adds_the_autocomplete_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" autocomplete="off" />');

        $view->assertSee('autocomplete="off"', false);

        $view = $this->blade('<x-eloquent-ui::form action="/" autocomplete="on" />');

        $view->assertSee('autocomplete="on"', false);
    }

    public function test_setting_a_name_adds_the_name_and_id_attributes(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" name="test" />');

        $view->assertSee('name="test"', false);
        $view->assertSee('id="test"', false);
    }

    public function test_setting_the_target_adds_the_target_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" target="_blank" />');

        $view->assertSee('target="_blank"', false);
    }

    public function test_setting_the_target_to_false_without_rel_sets_the_rel_attribute_to_noopener(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" target="_blank" />');

        $view->assertSee('rel="noopener noreferrer"', false);
    }

    public function test_setting_the_target_to_false_without_rel_noopener_adds_noopener_to_the_rel_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" target="_blank" rel="nofollow" />');

        $view->assertSee('rel="nofollow noopener"', false);
    }

    public function test_setting_the_rel_adds_the_rel_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" rel="nofollow" />');

        $view->assertSee('rel="nofollow"', false);
    }

    public function test_setting_the_charset_adds_the_charset_attribute(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" charset="utf-8" />');

        $view->assertSee('charset="utf-8"', false);
    }

    public function test_adding_custom_attributes_adds_them_to_the_form(): void
    {
        $view = $this->blade('<x-eloquent-ui::form action="/" data-custom-attribute="custom-value" class="custom-class" />');

        $view->assertSee('data-custom-attribute="custom-value"', false);
        $view->assertSee('class="custom-class"', false);
    }
}
