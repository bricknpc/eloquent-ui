<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Http\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin FormRequest
 */
trait CanSubmitAnother // @phpstan-ignore trait.unused
{
    public function wantsToSubmitAnother(): bool
    {
        return $this->has('submit-another');
    }

    public function redirect(string $defaultAction = '/'): RedirectResponse
    {
        return $this->wantsToSubmitAnother()
            ? back()->withInput()
            : redirect($defaultAction);
    }
}
