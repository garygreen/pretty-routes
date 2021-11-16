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

use Helldar\LaravelRoutesCore\Contracts\Config as ConfigContract;
use Illuminate\Support\Facades\Config as Conf;

class Config implements ConfigContract
{
    public function getApiMiddleware(): array
    {
        return (array) $this->get('api_middleware');
    }

    public function getWebMiddleware(): array
    {
        return (array) $this->get('web_middleware');
    }

    public function getHideMethods(): array
    {
        return $this->get('hide_methods', []);
    }

    public function getHideMatching(): array
    {
        return $this->get('hide_matching', []);
    }

    public function getDomainForce(): bool
    {
        return (bool) $this->get('domain_force');
    }

    public function getUrl(): string
    {
        return Conf::get('app.url');
    }

    public function getNamespace(): ?string
    {
        return Conf::get('modules.namespace');
    }

    protected function get(string $key, $default = null)
    {
        return Conf::get('pretty-routes.' . $key, $default);
    }
}
