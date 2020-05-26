<?php namespace PrettyRoutes;

use Route;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider {

    /**
     * Boot.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'pretty-routes'
        );

        if (config('pretty-routes.debug_only', true) && empty(config('app.debug'))) {
            return;
        }

        $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'pretty-routes');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('pretty-routes.php')
        ]);

        Route::get(config('pretty-routes.url'), 'PrettyRoutes\PrettyRoutesController@show')
            ->name('pretty-routes.show')
            ->middleware(config('pretty-routes.middlewares'));
    }

}
