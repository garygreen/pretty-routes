<?php

namespace Tests;

use Illuminate\Support\Facades\Config;

final class TranslationsTest extends TestCase
{
    public function testDefaultTranslation()
    {
        $this->setConfigLocale('en');

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('Routes');
        $response->assertSee('Middlewares');
        $response->assertSee('Loading... Please wait...');
        $response->assertSee('Routes per page');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }

    public function testChangedAppLocaleTranslation()
    {
        $this->setConfigLocale('ru');

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('Маршруты');
        $response->assertSee('Мидлвари');
        $response->assertSee('Загрузка... Пожалуйста, подождите...');
        $response->assertSee('Записей на странице');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testChangedPackageLocaleTranslation()
    {
        $this->setConfigLocale('en', 'ru');

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('Маршруты');
        $response->assertSee('Мидлвари');
        $response->assertSee('Загрузка... Пожалуйста, подождите...');
        $response->assertSee('Записей на странице');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testIncorrectLocaleTranslation()
    {
        $this->setConfigLocale('en', 'foo');

        $response = $this->get('/routes');

        $response->assertStatus(200);
        $response->assertSee('Routes');
        $response->assertSee('Middlewares');
        $response->assertSee('Loading... Please wait...');
        $response->assertSee('Routes per page');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }

    protected function setConfigLocale(string $app, string $package = null): void
    {
        Config::set('app.locale', $app);
        Config::set('pretty-routes.locale_force', $package ?: false);
    }
}
