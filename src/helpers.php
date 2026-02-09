<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI;

use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @param array<string, mixed> $replace
 */
function __(string $key, array $replace = [], ?string $locale = null): string
{
    /** @var string $value */
    $value = \__($key, $replace, $locale);

    return $value;
}

function ns(): string
{
    /** @var string $value */
    $value = config('eloquent-ui.data-namespace', 'eloquent-ui');

    return $value;
}

function meta(): Htmlable
{
    $content = [
        'ns' => str(ns())->camel(),
    ];

    return new HtmlString('<meta name="eloquent-ui" content="' . json_encode($content) . '" />');
}
