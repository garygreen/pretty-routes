<?php

namespace PrettyRoutes\Http;

use Illuminate\Routing\Controller as BaseController;
use PrettyRoutes\Support\Routes;

class PrettyRoutesController extends BaseController
{
    /**
     * Getting a template for routes.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('pretty-routes::routes');
    }

    /**
     * Getting a list of routes.
     *
     * @param  \PrettyRoutes\Support\Routes  $routes
     *
     * @return array
     */
    public function routes(Routes $routes)
    {
        return $routes->get();
    }
}
