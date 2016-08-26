<?php namespace PrettyRoutes;

use PrettyRoutes\MainController;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider {

    /**
     * Register.
     *
     * @return
     */
    public function register()
    {
        //
    }

    /**
     * Boot.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/views'), 'pretty-routes');
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'pretty-routes'
        );
        $this->publishes([
            __DIR__ . '/config.php' => config_path('pretty-routes.php')
        ]);

        $this->app['router']->get($this->app['config']->get('pretty-routes.url'), MainController::class . '@show');
    }

}
