<?php

namespace PrettyRoutes\Http;

use Illuminate\Routing\Controller as BaseController;
use PrettyRoutes\Support\Routes;

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
     * @param  \PrettyRoutes\Support\Routes  $routes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function routes(Routes $routes)
    {
        return response()->json(
            $routes->get()
        );
    }
}
