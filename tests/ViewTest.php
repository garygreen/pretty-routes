<?php

namespace Tests;

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
}
