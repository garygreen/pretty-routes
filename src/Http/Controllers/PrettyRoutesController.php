<?php

namespace PrettyRoutes\Http\Controllers;

use Closure;
use Illuminate\Routing\Controller as BaseController;
use PrettyRoutes\Support\Routes;

class PrettyRoutesController extends BaseController
{
    /**
     * Show pretty routes.
     *
     * @param  \PrettyRoutes\Support\Routes  $routes
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Routes $routes)
    {
        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        return view('pretty-routes::routes', [
            'routes'            => $routes->get(),
            'middlewareClosure' => $middlewareClosure,
        ]);
    }
}
