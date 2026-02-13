<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Views\Components;

use BrickNPC\EloquentUI\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use BrickNPC\EloquentUI\Http\Views\Components\Card\Tabs;

/**
 * @internal
 */
#[CoversClass(Tabs::class)]
class TabsTest extends TestCase
{
    public function test_register_tab_returns_a_string_id(): void
    {
        $tabs = new Tabs();

        $id = $tabs->registerTab('My Tab');

        $this->assertIsString($id);
        $this->assertNotEmpty($id);
    }

    public function test_registering_multiple_tabs_with_same_title_returns_unique_ids(): void
    {
        $tabs = new Tabs();

        $firstId  = $tabs->registerTab('Duplicate');
        $secondId = $tabs->registerTab('Duplicate');

        $this->assertNotSame($firstId, $secondId);
    }

    public function test_registering_multiple_tabs_returns_unique_ids(): void
    {
        $tabs = new Tabs();

        $ids = [
            $tabs->registerTab('First'),
            $tabs->registerTab('Second'),
            $tabs->registerTab('Third'),
        ];

        $this->assertCount(3, array_unique($ids));
    }

    public function test_component_renders_the_expected_view(): void
    {
        $component = new Tabs();

        $view = $component->render();

        $this->assertSame(
            'eloquent-ui::components.card.tabs',
            $view->name(),
        );
    }
}
