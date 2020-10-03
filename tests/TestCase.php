<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PrettyRoutes\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $this->setConfig($app);
        $this->setRoutes($app);
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function setRoutes($app)
    {
        $app['router']->get('/foo', function () {
        });

        $app['router']->match(['PUT', 'PATCH'], '/bar', function () {
        });

        $app['router']->get('/_ignition/baq', function () {
        });

        $app['router']->get('/telescope/baw', function () {
        });

        $app['router']->get('/_debugbar/bae', function () {
        });
    }

    protected function setConfig($app)
    {
        $app['config']->set('pretty-routes.hide_methods', ['HEAD', 'GET']);
        $app['config']->set('pretty-routes.debug_only', false);
    }
}
