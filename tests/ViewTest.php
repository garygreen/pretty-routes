<?php

namespace Tests;

class ViewTest extends TestCase
{
    public function testTexts()
    {
        $response = $this->get('/routes');

        $response->assertSee('Routes list');
        $response->assertSee('Laravel');

        $response->assertDontSee('Foo Bar');
    }

    public function testHideMethods()
    {
        $response = $this->get('/routes');

        $response->assertDontSee('foo');
        $response->assertSee('bar');
    }

    public function testHideRoutes()
    {
        $response = $this->get('/routes');

        $response->assertSee('bar');
        $response->assertDontSee('_ignition');
        $response->assertDontSee('telescope');
        $response->assertDontSee('_debugbar');
    }
}
