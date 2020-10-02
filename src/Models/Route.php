<?php

namespace PrettyRoutes\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as IlluminateRoute;
use PrettyRoutes\Facades\Annotation;

class Route implements Arrayable
{
    protected $priority;

    protected $methods;

    protected $domain;

    protected $path;

    protected $name;

    protected $action;

    protected $middlewares;

    protected $deprecated;

    public function __construct(IlluminateRoute $route, int $priority)
    {
        $this->priority    = $priority;
        $this->methods     = $route->methods();
        $this->domain      = $route->getDomain();
        $this->path        = $route->uri();
        $this->name        = $route->getName();
        $this->action      = $route->getActionMethod();
        $this->middlewares = $route->middleware();

        $this->setDeprecated($route);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getMethods(): array
    {
        return array_diff($this->methods, config('pretty-routes.hide_methods', []));
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getDeprecated(): bool
    {
        return $this->deprecated;
    }

    public function setDeprecated(IlluminateRoute $route): void
    {
        $this->deprecated = Annotation::isDeprecated($route->getActionName());
    }

    public function toArray()
    {
        return [
            'priority'    => $this->getPriority(),
            'methods'     => $this->getMethods(),
            'domain'      => $this->getDomain(),
            'path'        => $this->getPath(),
            'name'        => $this->getName(),
            'action'      => $this->getAction(),
            'middlewares' => $this->getMiddlewares(),
        ];
    }
}
