<?php

namespace PrettyRoutes\Support;

use Illuminate\Support\Facades\Route;

final class Routes
{
    public function get()
    {
        $routes = $this->getRoutes();

        foreach ($this->getHideMatchings() as $regex) {
            $routes = $routes->filter(static function ($value) use ($regex) {
                return ! preg_match($regex, $value->uri());
            });
        }

        return $routes;
    }

    protected function getRoutes()
    {
        return collect(Route::getRoutes());
    }

    protected function getHideMatchings(): array
    {
        return config('pretty-routes.hide_matching', []);
    }
}
