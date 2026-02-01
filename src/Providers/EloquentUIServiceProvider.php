<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Providers;

use Illuminate\Support\ServiceProvider;

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
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/eloquent-ui.php',
            'eloquent-ui',
        );
    }
}
