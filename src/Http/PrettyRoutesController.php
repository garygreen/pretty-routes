<?php

namespace PrettyRoutes\Http;

use Helldar\LaravelRoutesCore\Support\Routes;
use Illuminate\Routing\Controller as BaseController;

class PrettyRoutesController extends BaseController
{
    /**
     * Getting a template for routes.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('pretty-routes::layout');
    }

    /**
     * Getting a list of routes.
     *
     * @param  \Helldar\LaravelRoutesCore\Support\Routes  $routes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function routes(Routes $routes)
    {
        $content = $routes
            ->hideMethods(config('pretty-routes.hide_methods', []))
            ->hideMatching(config('pretty-routes.hide_matching', []))
            ->get();

        return response()->json($content);
    }
}
