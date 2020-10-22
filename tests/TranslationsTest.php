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

        $response->assertSee('Action');
        $response->assertSee('All');
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
        $response->assertSee('Routes per page');
        $response->assertSee('Routes');
        $response->assertSee('Search');
        $response->assertSee('Show');
        $response->assertSee('Without');
        $response->assertSee('{0}-{1} of {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Записей на странице');
    }

    public function testChangedAppLocaleTranslation()
    {
        $this->setConfigLocale('ru');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('URI');
        $response->assertSee('{0}-{1} из {2}');
        $response->assertSee('Все');
        $response->assertSee('Данные отсутствуют');
        $response->assertSee('Домен');
        $response->assertSee('Загрузка... Пожалуйста, подождите...');
        $response->assertSee('Записей на странице');
        $response->assertSee('из');
        $response->assertSee('Маршруты');
        $response->assertSee('Методы');
        $response->assertSee('Мидлвари');
        $response->assertSee('Модуль');
        $response->assertSee('Название');
        $response->assertSee('Не указано');
        $response->assertSee('Обновить список маршрутов');
        $response->assertSee('Открыть страницу проекта в GitHub');
        $response->assertSee('Поиск');
        $response->assertSee('Показать');
        $response->assertSee('Приоритет');
        $response->assertSee('Только');
        $response->assertSee('Устаревшие');
        $response->assertSee('Экшены');
        $response->assertSee('Элементы не найдены');

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
