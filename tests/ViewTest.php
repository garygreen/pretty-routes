<?php

namespace Tests;

use PrettyRoutes\Support\Routes;

class ViewTest extends TestCase
{
    public function testView()
    {
        $service = new Routes();

        $view = $this->view('pretty-routes::routes', [
            'routes' => $service->get(),
        ]);

        $view->assertSee('Routes list');
        $view->assertSee('Laravel');
        $view->assertDontSee('Foo Bar');
    }
}
