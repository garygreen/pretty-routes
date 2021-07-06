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

namespace Tests\Localizations;

use Tests\TestCase;

final class EnTest extends TestCase
{
    public function testApp()
    {
        $this->setConfigLocale('en');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('All');
        $response->assertSee('All');
        $response->assertSee('Api');
        $response->assertSee('Clear route cache');
        $response->assertSee('Deprecated');
        $response->assertSee('Domain');
        $response->assertSee('Loading... Please wait...');
        $response->assertSee('Methods');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Name');
        $response->assertSee('No data available');
        $response->assertSee('No matching records found');
        $response->assertSee('of');
        $response->assertSee('Only');
        $response->assertSee('Open the project page on GitHub');
        $response->assertSee('Path');
        $response->assertSee('Priority');
        $response->assertSee('Refresh the list of routes');
        $response->assertSee('Route types');
        $response->assertSee('Routes per page');
        $response->assertSee('Routes');
        $response->assertSee('Search');
        $response->assertSee('Show');
        $response->assertSee('Web');
        $response->assertSee('Without');

        $response->assertSee('{0}-{1} of {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }

    public function testPackage()
    {
        $this->setConfigLocale('en', 'en');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('All');
        $response->assertSee('All');
        $response->assertSee('Api');
        $response->assertSee('Clear route cache');
        $response->assertSee('Deprecated');
        $response->assertSee('Domain');
        $response->assertSee('Loading... Please wait...');
        $response->assertSee('Methods');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Name');
        $response->assertSee('No data available');
        $response->assertSee('No matching records found');
        $response->assertSee('of');
        $response->assertSee('Only');
        $response->assertSee('Open the project page on GitHub');
        $response->assertSee('Path');
        $response->assertSee('Priority');
        $response->assertSee('Refresh the list of routes');
        $response->assertSee('Route types');
        $response->assertSee('Routes per page');
        $response->assertSee('Routes');
        $response->assertSee('Search');
        $response->assertSee('Show');
        $response->assertSee('Web');
        $response->assertSee('Without');

        $response->assertSee('{0}-{1} of {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }

    public function testIncorrect()
    {
        $this->setConfigLocale('en', 'foo');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('All');
        $response->assertSee('All');
        $response->assertSee('Api');
        $response->assertSee('Clear route cache');
        $response->assertSee('Deprecated');
        $response->assertSee('Domain');
        $response->assertSee('Loading... Please wait...');
        $response->assertSee('Methods');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Name');
        $response->assertSee('No data available');
        $response->assertSee('No matching records found');
        $response->assertSee('of');
        $response->assertSee('Only');
        $response->assertSee('Open the project page on GitHub');
        $response->assertSee('Path');
        $response->assertSee('Priority');
        $response->assertSee('Refresh the list of routes');
        $response->assertSee('Route types');
        $response->assertSee('Routes per page');
        $response->assertSee('Routes');
        $response->assertSee('Search');
        $response->assertSee('Show');
        $response->assertSee('Web');
        $response->assertSee('Without');

        $response->assertSee('{0}-{1} of {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }
}
