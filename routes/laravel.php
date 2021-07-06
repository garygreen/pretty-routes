<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/pretty-routes" project.           *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 * @author Gary Green <holegary@gmail.com>                                    *
 *                                                                            *
 * @copyright 2021 Andrey Helldar, Gary Green                                 *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/pretty-routes                       *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

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
