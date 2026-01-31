<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI;

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
