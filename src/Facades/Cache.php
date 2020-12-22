<?php

namespace PrettyRoutes\Facades;

use Illuminate\Support\Facades\Facade;
use PrettyRoutes\Support\Cache as Support;

/**
 * @method static \PrettyRoutes\Support\Cache when($value);
 * @method static bool routeClear();
 */
final class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
