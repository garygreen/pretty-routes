<?php namespace PrettyRoutes;

use Route;
use Closure;
use Illuminate\Http\Response;

class MainMiddleware {

    /**
     * Show pretty routes.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if ($request->is(config('pretty-routes.url')))
        {
            $middlewareClosure = function ($middleware) {
                return $middleware instanceof Closure ? 'Closure' : $middleware;
            };

            $routes = collect(Route::getRoutes())->filter(function ($value, $key) {
                return !preg_match('#^_debugbar#', $value->uri());
            });

            return new Response(view('pretty-routes::routes', compact('routes', 'middlewareClosure')));
        }

        return $next($request);
    }

}
