<?php namespace PrettyRoutes;

use Route;
use Illuminate\Routing\Controller;

class MainController extends Controller {

    /**
     * Show pretty routes.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('pretty-routes::routes', [
            'routes' => Route::getRoutes(),
        ]);
    }

}
