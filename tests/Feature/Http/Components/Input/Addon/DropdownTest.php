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
class DropdownTest extends TestCase
{
    use InteractsWithViews;

    public function test_it_creates_a_dropdown(): void
    {
        $this->markTestIncomplete('This feature is not yet implemented.');
    }
}
