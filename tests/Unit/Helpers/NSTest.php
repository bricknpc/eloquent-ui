<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Helpers;

use function BrickNPC\EloquentUI\ns;

use Illuminate\Support\Facades\Config;
use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversFunction;

/**
 * @internal
 */
#[CoversFunction('BrickNPC\EloquentUI\ns')]
class NSTest extends TestCase
{
    protected function tearDown(): void
    {
        // Reset config to default after each test
        Config::set('eloquent-ui.data-namespace', 'eloquent-ui');

        parent::tearDown();
    }

    public function test_it_returns_configured_namespace(): void
    {
        Config::set('eloquent-ui.data-namespace', 'custom-namespace');

        $result = ns();

        $this->assertSame('custom-namespace', $result);
    }

    public function test_it_returns_string_type(): void
    {
        $result = ns();

        $this->assertIsString($result);
    }

    public function test_it_returns_non_empty_string(): void
    {
        $result = ns();

        $this->assertNotEmpty($result);
    }

    public function test_it_handles_empty_string_configuration(): void
    {
        Config::set('eloquent-ui.data-namespace', '');

        $result = ns();

        $this->assertSame('', $result);
    }

    public function test_it_handles_numeric_string_configuration(): void
    {
        Config::set('eloquent-ui.data-namespace', '123');

        $result = ns();

        $this->assertSame('123', $result);
    }

    public function test_it_handles_namespace_with_hyphens(): void
    {
        Config::set('eloquent-ui.data-namespace', 'my-custom-namespace');

        $result = ns();

        $this->assertSame('my-custom-namespace', $result);
    }

    public function test_it_handles_namespace_with_underscores(): void
    {
        Config::set('eloquent-ui.data-namespace', 'my_custom_namespace');

        $result = ns();

        $this->assertSame('my_custom_namespace', $result);
    }

    public function test_it_handles_namespace_with_dots(): void
    {
        Config::set('eloquent-ui.data-namespace', 'my.custom.namespace');

        $result = ns();

        $this->assertSame('my.custom.namespace', $result);
    }

    public function test_it_handles_namespace_with_special_characters(): void
    {
        Config::set('eloquent-ui.data-namespace', 'ns:custom@2024');

        $result = ns();

        $this->assertSame('ns:custom@2024', $result);
    }

    public function test_it_returns_consistent_value_across_multiple_calls(): void
    {
        Config::set('eloquent-ui.data-namespace', 'consistent-namespace');

        $result1 = ns();
        $result2 = ns();
        $result3 = ns();

        $this->assertSame($result1, $result2);
        $this->assertSame($result2, $result3);
    }

    public function test_it_reflects_config_changes_immediately(): void
    {
        Config::set('eloquent-ui.data-namespace', 'first-namespace');
        $result1 = ns();

        Config::set('eloquent-ui.data-namespace', 'second-namespace');
        $result2 = ns();

        $this->assertSame('first-namespace', $result1);
        $this->assertSame('second-namespace', $result2);
        $this->assertNotSame($result1, $result2);
    }

    public function test_it_uses_default_when_config_key_does_not_exist(): void
    {
        // Clear the entire config
        Config::set('eloquent-ui', []);

        $result = ns();

        $this->assertSame('eloquent-ui', $result);
    }

    public function test_it_handles_camelcase_namespace(): void
    {
        Config::set('eloquent-ui.data-namespace', 'myCustomNamespace');

        $result = ns();

        $this->assertSame('myCustomNamespace', $result);
    }

    public function test_it_handles_pascalcase_namespace(): void
    {
        Config::set('eloquent-ui.data-namespace', 'MyCustomNamespace');

        $result = ns();

        $this->assertSame('MyCustomNamespace', $result);
    }

    public function test_it_handles_long_namespace(): void
    {
        $longNamespace = str_repeat('namespace-', 10) . 'end';
        Config::set('eloquent-ui.data-namespace', $longNamespace);

        $result = ns();

        $this->assertSame($longNamespace, $result);
    }

    public function test_it_handles_single_character_namespace(): void
    {
        Config::set('eloquent-ui.data-namespace', 'x');

        $result = ns();

        $this->assertSame('x', $result);
    }
}
