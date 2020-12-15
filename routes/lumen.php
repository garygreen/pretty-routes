<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as'         => 'pretty-routes',
    'middleware' => config('pretty-routes.middlewares'),
    'prefix'     => config('pretty-routes.url'),
], static function () {
    Route::get('/', [
        'middleware' => config('pretty-routes.web_middleware'),
        'uses'       => 'PrettyRoutes\Http\PrettyRoutesController@show',
        'as'         => 'show',
    ]);

    Route::get('json', [
        'middleware' => config('pretty-routes.api_middleware'),
        'uses'       => 'PrettyRoutes\Http\PrettyRoutesController@routes',
        'as'         => 'list',
    ]);

    Route::post('clear', [
        'middleware' => config('pretty-routes.api_middleware'),
        'uses'       => 'PrettyRoutes\Http\PrettyRoutesController@clear',
        'as'         => 'clear',
    ]);
});
