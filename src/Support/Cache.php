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

namespace PrettyRoutes\Support;

use Illuminate\Support\Facades\Artisan;

class Cache
{
    protected $when = true;

    public function when($value): self
    {
        $this->when = (bool) $value;

        return $this;
    }

    public function routeClear(): bool
    {
        return $this->when && $this->clear('route:clear');
    }

    protected function clear(string $command): bool
    {
        Artisan::call($command);

        return true;
    }
}
