<?php

namespace PrettyRoutes;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/pretty-routes.php',
            'pretty-routes'
        );
    }

    public function boot()
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'pretty-routes');

        $this->publishes([
            __DIR__ . '/../config/pretty-routes.php' => config_path('pretty-routes.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    protected function isDisabled(): bool
    {
        return config('pretty-routes.debug_only', true) && empty(config('app.debug'));
    }
}
