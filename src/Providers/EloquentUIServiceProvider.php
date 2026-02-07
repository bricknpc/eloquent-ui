<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use BrickNPC\EloquentUI\Database\Schema\CurrencyColumn;

class EloquentUIServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'eloquent-ui');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');

        $this->publishes([
            __DIR__ . '/../../config/eloquent-ui.php' => config_path('eloquent-ui.php'),
        ], 'eloquent-ui-config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/eloquent-ui'),
        ], 'eloquent-ui-views');

        $this->publishes([
            __DIR__ . '/../../public/build' => public_path('vendor/eloquent-ui'),
        ], 'eloquent-ui-assets');

        $this->publishes([
            __DIR__ . '/../../lang' => lang_path('vendor/eloquent-ui'),
        ], 'eloquent-ui-translations');

        $this->registerBlueprintMacros();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/eloquent-ui.php',
            'eloquent-ui',
        );
    }

    protected function registerBlueprintMacros(): void
    {
        Blueprint::macro('currency', function (string $name) {
            /* @var Blueprint $this */
            return new CurrencyColumn($this, $name);
        });

        Blueprint::macro('dropCurrency', function (string $name) {
            /* @var Blueprint $this */
            $this->dropColumn([$name, $name . CurrencyColumn::CURRENCY_COLUMN_SUFFIX]);
        });

        Blueprint::macro('dropCurrencyIndex', function (string $name, bool $double = false) {
            /* @var Blueprint $this */
            if ($double) {
                // Drop the composite index on both columns
                $this->dropIndex([$name, $name . CurrencyColumn::CURRENCY_COLUMN_SUFFIX]);
            } else {
                // Drop the single index on amount column
                $this->dropIndex([$name]);
            }
        });
    }
}
