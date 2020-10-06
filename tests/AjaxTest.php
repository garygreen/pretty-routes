<?php

namespace Tests;

final class AjaxTest extends TestCase
{
    public function testStructure()
    {
        $response = $this->get('/routes/json');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'priority',
                'methods',
                'domain',
                'path',
                'name',
                'module',
                'action',
                'middlewares',
                'deprecated',
            ],
        ]);
    }

    public function testHideMethods()
    {
        $response = $this->get('/routes/json');

        $response->assertStatus(200);

        $response->assertDontSee('"foo"', false);
        $response->assertSee('"bar"', false);
    }

    public function testHideRoutes()
    {
        $response = $this->get('/routes/json');

        $response->assertStatus(200);
        $response->assertSee('"bar"', false);
        $response->assertDontSee('_ignition');
        $response->assertDontSee('telescope');
        $response->assertDontSee('_debugbar');
    }
}
