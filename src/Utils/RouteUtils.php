<?php

namespace PrettyRoutes\Utils;

use Illuminate\Support\Facades\Route;

class RouteUtils
{
    /**
     * Get all routes
     * 
     * @return array
     */
    public static function get()
    {
        return Route::getRoutes();
    }

    /**
     * Filter Routes By Search Text
     * 
     * @param string $search Search text
     * @return array
     */
    public static function filter($search)
    {
        $routes = [];
        $search = strtolower($search);
        foreach (Route::getRoutes() as $route) {
            $next = false;
            // methods filter
            foreach (array_diff($route->methods(), config('pretty-routes.hide_methods')) as $method) {
                if (str_contains(strtolower($method), $search)) {
                    array_push($routes, $route);
                    $next = true;
                }
            }
            if ($next) continue;

            // domain filter
            if (strlen($route->domain()) != 0 and str_contains(strtolower($route->domain()), $search)) {
                array_push($routes, $route);
                continue;
            }

            // uri filter
            if (str_contains(strtolower($route->uri()), $search)) {
                array_push($routes, $route);
                continue;
            }

            // name filter
            if (str_contains(strtolower($route->getName()), $search)) {
                array_push($routes, $route);
                continue;
            }

            // action filter 
            if (str_contains(strtolower($route->getActionName()), $search)) {
                array_push($routes, $route);
                continue;
            }

            // middleware filter
            foreach (array_diff($route->middleware(), config('pretty-routes.hide_methods')) as $middleware) {
                if (str_contains(strtolower($middleware), $search)) {
                    array_push($routes, $route);
                    $next = true;
                }
            }
            if ($next) continue;
        }

        return $routes;
    }
}
