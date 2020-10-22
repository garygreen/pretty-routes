<?php

namespace PrettyRoutes;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            $this->fullPath('config/pretty-routes.php'),
            'pretty-routes'
        );
    }

    public function boot()
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->loadViewsFrom(
            $this->fullPath('resources/views'),
            'pretty-routes'
        );

        $this->publishes([
            $this->fullPath('config/pretty-routes.php') => config_path('pretty-routes.php'),
        ]);

        $this->loadRoutesFrom(
            $this->fullPath('routes/web.php')
        );
    }

    protected function isDisabled(): bool
    {
        return config('pretty-routes.debug_only', true) && ! config('app.debug');
    }

    protected function fullPath(string $path): string
    {
        return realpath(__DIR__ . '/../' . ltrim($path, '/'));
    }
}
