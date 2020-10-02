<?php

namespace PrettyRoutes\Http;

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
        return view('pretty-routes::routes', [
            'routes' => $routes->get(),
        ]);
    }
}
