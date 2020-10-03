<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PrettyRoutes\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $this->setRoutes($app);
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function setRoutes($app)
    {
        $app['router']->get('/foo', function () {
            //
        });

        $app['router']->head('/bar', function () {
            //
        });

        $app['router']->match(['PUT', 'PATCH'], '/baz', function () {
            //
        });

        $app['router']->get('/_ignition/baq', function () {
            //
        });

        $app['router']->get('/telescope/baw', function () {
            //
        });

        $app['router']->get('/_debugbar/bae', function () {
            //
        });
    }
}
