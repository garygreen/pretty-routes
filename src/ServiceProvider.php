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

namespace PrettyRoutes;

use Helldar\LaravelSupport\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            $this->fullPath('config/pretty-routes.php'),
            'pretty-routes'
        );
    }

    public function boot()
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->loadViewsFrom(
            $this->fullPath('resources/views'),
            'pretty-routes'
        );

        $this->publishes([
            $this->fullPath('config/pretty-routes.php') => $this->app->configPath('pretty-routes.php'),
        ]);

        $this->loadRoutesFrom(
            $this->routesPath()
        );
    }

    protected function isDisabled(): bool
    {
        return Config::get('pretty-routes.debug_only', true) && ! Config::get('app.debug');
    }

    protected function fullPath(string $path): string
    {
        return realpath(__DIR__ . '/../' . ltrim($path, '/'));
    }

    protected function routesPath(): string
    {
        return App::isLaravel()
            ? $this->fullPath('routes/laravel.php')
            : $this->fullPath('routes/lumen.php');
    }
}
