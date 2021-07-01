<?php

namespace PrettyRoutes;

use Closure;
use PrettyRoutes\Utils\RouteUtils;

class PrettyRoutesController
{
    /**
     * Show pretty routes.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $search = request('search');

        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        if ($search) {
            $routes = collect(RouteUtils::filter($search));
        } else {
            $routes = collect(RouteUtils::get());
        }

        foreach (config('pretty-routes.hide_matching') as $regex) {
            $routes = $routes->filter(function ($value, $key) use ($regex) {
                return !preg_match($regex, $value->uri());
            });
        }

        return view('pretty-routes::routes', [
            'routes' => $routes,
            'middlewareClosure' => $middlewareClosure,
        ]);
    }
}
