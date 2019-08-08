<?php

namespace Sweet;

use Closure;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class RoutesController
{
    /**
     * Show pretty routes.
     *
     * @return View
     */
    public function __invoke()
    {
        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        $routes = collect(Route::getRoutes());

        foreach (config('sweet-routes.hide_matching') as $regex) {
            $routes = $routes->filter(function ($value) use ($regex) {
                return !preg_match($regex, $value->uri());
            });
        }

        return view('sweet-routes::routes', compact(['routes', 'middlewareClosure']));
    }
}
