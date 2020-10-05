<?php

namespace PrettyRoutes\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PrettyRoutes\Facades\Annotation;

class Route implements Arrayable
{
    /** @var \Illuminate\Routing\Route */
    protected $route;

    protected $priority;

    public function __construct(IlluminateRoute $route, int $priority)
    {
        $this->route    = $route;
        $this->priority = ++$priority;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getMethods(): array
    {
        return array_values(array_diff(
            $this->route->methods(),
            config('pretty-routes.hide_methods', [])
        ));
    }

    public function getDomain(): ?string
    {
        return $this->route->domain() ?: null;
    }

    public function getPath(): string
    {
        return $this->route->uri();
    }

    public function getName(): ?string
    {
        return $this->route->getName();
    }

    public function getModule(): ?string
    {
        $namespace = config('modules.namespace');

        if ($namespace && Str::startsWith($this->getAction(), $namespace)) {
            $action   = Str::after($this->getAction(), $namespace);
            $splitted = explode('\\', ltrim($action, '\\'));

            return Arr::first($splitted);
        }

        return null;
    }

    public function getAction(): string
    {
        return ltrim($this->route->getActionName(), '\\');
    }

    public function getMiddlewares(): array
    {
        $middlewares = $this->route->middleware();

        if (method_exists($this->route, 'controllerMiddleware') && is_callable([$this->route, 'controllerMiddleware'])) {
            $middlewares = array_merge($middlewares, $this->route->controllerMiddleware());
        }

        return array_values($middlewares);
    }

    public function getDeprecated(): bool
    {
        return Annotation::isDeprecated($this->getAction());
    }

    public function toArray()
    {
        return [
            'priority'    => $this->getPriority(),
            'methods'     => $this->getMethods(),
            'domain'      => $this->getDomain(),
            'path'        => $this->getPath(),
            'name'        => $this->getName(),
            'module'      => $this->getModule(),
            'action'      => $this->getAction(),
            'middlewares' => $this->getMiddlewares(),
            'deprecated'  => $this->getDeprecated(),
        ];
    }
}
