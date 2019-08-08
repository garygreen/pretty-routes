<?php

namespace Sweet;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config.php', 'sweet-routes'
        );

        if (config('sweet-routes.debug_only', true) && empty(config('app.debug'))) {
            return;
        }

        $this->loadViewsFrom(dirname(__DIR__).'/views', 'sweet-routes');

        $this->publishes([
            __DIR__.'/../config.php' => config_path('sweet-routes.php'),
        ]);

        Route::get(config('sweet-routes.url'), RoutesController::class)
            ->name(config('sweet-routes.name'))
            ->middleware(config('sweet-routes.middlewares'));
    }
}
