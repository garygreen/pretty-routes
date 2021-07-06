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

namespace Tests;

use Illuminate\Support\Facades\Config;

class ViewTest extends TestCase
{
    public function testTexts()
    {
        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('<!DOCTYPE html>', false);
        $response->assertSee('<div id="app">', false);

        $response->assertDontSee('Foo Bar');
    }

    public function testClearRoutes()
    {
        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('const isEnabledCleanup = true;');
    }

    public function testProductionClearRoutes()
    {
        Config::set('app.env', 'production');

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('const isEnabledCleanup = false;');
    }

    public function testDisabledClearRoutes()
    {
        Config::set('app.debug', false);

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('const isEnabledCleanup = false;');
    }
}
