<?php

namespace PrettyRoutes\Http;

use Helldar\LaravelRoutesCore\Support\Routes;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

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
            ->setApiMiddlewares((array) config('pretty-routes.api_middleware'))
            ->setWebMiddlewares((array) config('pretty-routes.web_middleware'))
            ->setHideMethods(config('pretty-routes.hide_methods', []))
            ->setHideMatching(config('pretty-routes.hide_matching', []))
            ->setDomainForce(config('pretty-routes.domain_force', false))
            ->setUrl(config('app.url'))
            ->setNamespace(config('modules.namespace'))
            ->get();

        return response()->json($content);
    }

    /**
     * Clearing cached routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        if (config('app.env') !== 'production' && config('app.debug') === true) {
            Artisan::call('route:clear');

            return response()->json('ok');
        }

        return response()->json('disabled', 400);
    }
}
