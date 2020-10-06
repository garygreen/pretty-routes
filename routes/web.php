<?php

use Illuminate\Support\Facades\Route;

Route::name('pretty-routes.')
    ->middleware(config('pretty-routes.middlewares'))
    ->prefix(config('pretty-routes.url'))
    ->group(function () {
        Route::get('/', 'PrettyRoutes\Http\PrettyRoutesController@show')->name('show');
        Route::get('json', 'PrettyRoutes\Http\PrettyRoutesController@routes')->name('list');
    });
