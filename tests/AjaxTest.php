<?php

namespace Tests;

use Illuminate\Support\Facades\Validator;

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

    public function testValidateValues()
    {
        $response = $this->get('/routes/json');

        $response->assertStatus(200);

        $v = Validator::make($response->json(), [
            '*.priority'      => ['required', 'integer'],
            '*.methods'       => ['required', 'array'],
            '*.methods.*'     => ['required', 'string'],
            '*.domain'        => ['nullable', 'string'],
            '*.path'          => ['required', 'string'],
            '*.name'          => ['nullable', 'string'],
            '*.module'        => ['nullable', 'string'],
            '*.action'        => ['nullable', 'string'],
            '*.middlewares'   => ['nullable', 'array'],
            '*.middlewares.*' => ['nullable', 'string'],
            '*.deprecated'    => ['boolean'],
        ]);

        $this->assertFalse($v->fails());
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

    public function testClearRoutes()
    {
        $response = $this->post('/routes/clear');

        $response->assertStatus(200);
        $response->assertSee('ok');
        $response->assertDontSee('data');
    }
}
