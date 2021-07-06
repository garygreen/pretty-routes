<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/pretty-routes" project.           *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 * @author Gary Green <holegary@gmail.com>                                    *
 *                                                                            *
 * @copyright 2021 Andrey Helldar, Gary Green                                 *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/pretty-routes                       *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace PrettyRoutes\Support;

use Illuminate\Support\Facades\Artisan;

final class Cache
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
