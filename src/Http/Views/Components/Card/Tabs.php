<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Views\Components\Card;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Tabs extends Component
{
    /**
     * @var array<string, string>
     */
    private array $tabs = [];

    /**
     * Registers a tab with the card and returns the tab ID that the tab should use to render the tab content.
     */
    public function registerTab(string $title): string
    {
        do {
            $id = $this->getId($title);
        } while (array_key_exists($id, $this->tabs));

        $this->tabs[$id] = $title;

        return $id;
    }

    public function render(): View
    {
        return view('eloquent-ui::components.card.tabs');
    }

    private function getId(string $title): string
    {
        return uniqid(more_entropy: true) . str($title)->slug()->toString();
    }
}
