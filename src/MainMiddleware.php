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
            return new Response(view('pretty-routes::routes', [
                'routes' => Route::getRoutes(),
                'middlewareClosure' => $middlewareClosure,
            ]));
        }

        return $next($request);
    }

}
