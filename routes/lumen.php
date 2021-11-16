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
