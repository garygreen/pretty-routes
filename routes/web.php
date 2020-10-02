<?php

use Illuminate\Support\Facades\Route;

Route::name('pretty-routes.show')
    ->middleware(config('pretty-routes.middlewares'))
    ->get(config('pretty-routes.url'), 'PrettyRoutes\Http\Controllers\PrettyRoutesController@show');
