<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PrettyRoutes\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }
}
