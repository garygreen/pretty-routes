<?php namespace PrettyRoutes;

use Route;
use Closure;

class PrettyRoutesController {

    /**
     * Show pretty routes.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        $routes = collect(Route::getRoutes());

        foreach (config('pretty-routes.hide_matching') as $regex) {
            $routes = $routes->filter(function ($value) use ($regex) {
                return !str_is($regex, $value->uri());
            });
        }

        return view('pretty-routes::routes', [
            'routes' => $routes,
            'middlewareClosure' => $middlewareClosure,
        ]);
    }

}
