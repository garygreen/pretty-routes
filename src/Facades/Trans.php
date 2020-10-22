<?php

namespace PrettyRoutes\Facades;

use Illuminate\Support\Facades\Facade;
use PrettyRoutes\Support\Trans as Support;

/**
 * @method static array all()
 * @method static string get(string $key)
 */
final class Trans extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
