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

namespace PrettyRoutes\Facades;

use Illuminate\Support\Facades\Facade;
use PrettyRoutes\Support\Cache as Support;

/**
 * @method static \PrettyRoutes\Support\Cache when($value);
 * @method static bool routeClear();
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
