<?php

namespace PrettyRoutes\Facades;

use Illuminate\Support\Facades\Facade;
use PrettyRoutes\Support\Annotation as AnnotationSupport;

/**
 * @method static boolean isDeprecated(string $controller, string $method = null)
 * @method static boolean isDeprecatedClass(string $controller)
 * @method static boolean isDeprecatedMethod(string $controller, string $method)
 */
class Annotation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AnnotationSupport::class;
    }
}
