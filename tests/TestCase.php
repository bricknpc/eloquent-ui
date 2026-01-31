<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use BrickNPC\EloquentUI\Providers\EloquentUIServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EloquentUIServiceProvider::class,
        ];
    }
}
