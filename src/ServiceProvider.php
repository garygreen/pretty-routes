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
        $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'pretty-routes');
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'pretty-routes'
        );
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('pretty-routes.php')
        ]);

        if (empty(config('app.debug')))
        {
            return;
        }

        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $kernel->pushMiddleware('PrettyRoutes\MainMiddleware');
    }

}
