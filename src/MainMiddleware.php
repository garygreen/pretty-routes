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
        if ($request->path() == config('pretty-routes.url'))
        {
            return new Response(view('pretty-routes::routes', [
                'routes' => Route::getRoutes(),
            ]));
        }

        return $next($request);
    }

}
