<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Helpers;

use function BrickNPC\EloquentUI\ns;
use function BrickNPC\EloquentUI\meta;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\UsesFunction;
use PHPUnit\Framework\Attributes\CoversFunction;

/**
 * @internal
 */
#[CoversFunction('BrickNPC\EloquentUI\meta')]
#[UsesFunction('BrickNPC\EloquentUI\ns')]
class MetaTest extends TestCase
{
    public function test_it_returns_the_meta_tag(): void
    {
        $this->assertStringContainsString('<meta', (string) meta());
        $this->assertStringContainsString('name="eloquent-ui"', (string) meta());
    }

    public function test_contains_the_data_attribute_namespace(): void
    {
        $javaScriptNsVersion = str(ns())->camel();

        $this->assertStringContainsString((string) $javaScriptNsVersion, (string) meta());
    }
}
