<?php
/*
 * This file is part of the "dragon-code/pretty-routes" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/pretty-routes
 */

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
