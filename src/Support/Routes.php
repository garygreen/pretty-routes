<?php

namespace PrettyRoutes\Support;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;
use PrettyRoutes\Models\Route as RouteModel;

final class Routes
{
    public function get(): array
    {
        return $this->getRoutes()
            ->filter(function (Route $route) {
                return $this->allowUri($route->uri()) && $this->allowMethods($route->methods());
            })
            ->mapInto(RouteModel::class)
            ->toArray();
    }

    protected function getRoutes(): Collection
    {
        return collect(RouteFacade::getRoutes());
    }

    protected function allowUri(string $uri): bool
    {
        foreach ($this->getHideMatching() as $regex) {
            if (preg_match($regex, $uri)) {
                return false;
            }
        }

        return true;
    }

    protected function allowMethods(array $methods): bool
    {
        return count(array_diff($methods, $this->getHideMethods())) > 0;
    }

    protected function getHideMatching(): array
    {
        return config('pretty-routes.hide_matching', []);
    }

    protected function getHideMethods(): array
    {
        return config('pretty-routes.hide_methods', []);
    }
}
