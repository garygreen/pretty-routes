<?php

namespace Tests;

class ViewTest extends TestCase
{
    public function testTexts()
    {
        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('Routes list');
        $response->assertSee('Laravel');

        $response->assertDontSee('Foo Bar');
    }
}
