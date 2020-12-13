<?php

use Illuminate\Support\Facades\Route;

Route::name('pretty-routes.')
    ->middleware(config('pretty-routes.middlewares'))
    ->prefix(config('pretty-routes.url'))
    ->group(function () {
        Route::middleware(config('pretty-routes.web_middleware'))
            ->get('/', 'PrettyRoutes\Http\PrettyRoutesController@show')
            ->name('show');

        Route::middleware(config('pretty-routes.api_middleware'))
            ->get('json', 'PrettyRoutes\Http\PrettyRoutesController@routes')
            ->name('list');

        Route::middleware(config('pretty-routes.api_middleware'))
            ->post('clear', 'PrettyRoutes\Http\PrettyRoutesController@clear')
            ->name('clear');
    });
