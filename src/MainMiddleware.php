<?php namespace PrettyRoutes;

use Route;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class MainMiddleware
{

    /**
     * Show pretty routes.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if ($request->path() == config('pretty-routes.url')) {
            $rutas = Route::getRoutes();
            return new Response(view('pretty-routes::routes', [
                'routes' => $this->paginate($rutas),
            ]));
        }
        return $next($request);
    }

    protected function paginate($items, $perPage = 20)
    {
        $pageStart = \Request::get('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $currentPageItems = array_slice($items->get(), $offSet, $perPage, true);
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }
}
