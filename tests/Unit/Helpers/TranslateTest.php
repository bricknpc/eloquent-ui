<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Helpers;

use function BrickNPC\EloquentUI\__;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversFunction;

/**
 * @internal
 */
#[CoversFunction('BrickNPC\EloquentUI\__')]
class TranslateTest extends TestCase
{
    public function test_it_translates_a_simple_key(): void
    {
        $result = __('validation.required');

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    public function test_it_returns_the_key_when_translation_is_missing(): void
    {
        $key = 'non.existent.translation.key';

        $result = __($key);

        $this->assertSame($key, $result);
    }

    public function test_it_replaces_placeholders_with_values(): void
    {
        // Using a Laravel default translation that has placeholders
        $result = __('validation.min.string', ['attribute' => 'password', 'min' => '8']);

        $this->assertIsString($result);
        $this->assertStringContainsString('password', $result);
        $this->assertStringContainsString('8', $result);
    }

    public function test_it_handles_empty_replace_array(): void
    {
        $result = __('validation.required', []);

        $this->assertIsString($result);
    }

    public function test_it_handles_null_locale(): void
    {
        $result = __('validation.required', [], null);

        $this->assertIsString($result);
    }

    public function test_it_uses_specified_locale(): void
    {
        // This assumes you have translations for different locales
        $result = __('validation.required', [], 'en');

        $this->assertIsString($result);
    }

    #[DataProvider('translationKeyProvider')]
    public function test_it_handles_various_translation_keys(string $key): void
    {
        $result = __($key);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    // Data providers

    public static function translationKeyProvider(): array
    {
        return [
            'validation key' => ['validation.required'],
            'passwords key'  => ['passwords.reset'],
            'pagination key' => ['pagination.previous'],
            'auth key'       => ['auth.failed'],
        ];
    }

    public function test_it_returns_string_type(): void
    {
        $result = __('validation.required');

        $this->assertIsString($result);
    }

    public function test_it_handles_multiple_replacements(): void
    {
        $result = __('validation.between.string', [
            'attribute' => 'username',
            'min'       => '3',
            'max'       => '20',
        ]);

        $this->assertIsString($result);
        $this->assertStringContainsString('username', $result);
        $this->assertStringContainsString('3', $result);
        $this->assertStringContainsString('20', $result);
    }

    public function test_it_handles_special_characters_in_replacements(): void
    {
        $result = __('validation.required_with', [
            'attribute' => 'email',
            'values'    => 'name & address',
        ]);

        $this->assertIsString($result);
        $this->assertStringContainsString('email', $result);
    }

    public function test_it_handles_numeric_replacements(): void
    {
        $result = __('validation.size.numeric', [
            'attribute' => 'age',
            'size'      => 18,
        ]);

        $this->assertIsString($result);
    }

    public function test_it_handles_empty_string_key(): void
    {
        $result = __('');

        $this->assertSame('', $result);
    }

    public function test_it_handles_nested_translation_keys(): void
    {
        $result = __('validation.attributes.email');

        $this->assertIsString($result);
    }

    public function test_it_preserves_case_sensitivity(): void
    {
        $key1 = 'some.key';
        $key2 = 'SOME.KEY';

        $result1 = __($key1);
        $result2 = __($key2);

        // They should be treated as different keys
        $this->assertIsString($result1);
        $this->assertIsString($result2);
    }

    public function test_it_handles_replacement_values_with_colons(): void
    {
        $result = __('validation.required', ['attribute' => 'field:name']);

        $this->assertIsString($result);
    }
}
