<?php
/*
 * This file is part of the "dragon-code/pretty-routes" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/pretty-routes
 */

namespace Tests\Localizations;

use Tests\TestCase;

class RuTest extends TestCase
{
    public function testApp()
    {
        $this->setConfigLocale('ru');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Api');
        $response->assertSee('URI');
        $response->assertSee('Web');
        $response->assertSee('Все');
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
        $response->assertSee('Очистить кэш роутов');
        $response->assertSee('Поиск');
        $response->assertSee('Показать');
        $response->assertSee('Приоритет');
        $response->assertSee('Типы маршрутов');
        $response->assertSee('Только');
        $response->assertSee('Устаревшие');
        $response->assertSee('Экшены');
        $response->assertSee('Элементы не найдены');

        $response->assertSee('{0}-{1} из {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testPackage()
    {
        $this->setConfigLocale('en', 'ru');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Api');
        $response->assertSee('URI');
        $response->assertSee('Web');
        $response->assertSee('Все');
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
        $response->assertSee('Очистить кэш роутов');
        $response->assertSee('Поиск');
        $response->assertSee('Показать');
        $response->assertSee('Приоритет');
        $response->assertSee('Типы маршрутов');
        $response->assertSee('Только');
        $response->assertSee('Устаревшие');
        $response->assertSee('Экшены');
        $response->assertSee('Элементы не найдены');

        $response->assertSee('{0}-{1} из {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testIncorrect()
    {
        $this->setConfigLocale('ru', 'foo');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Api');
        $response->assertSee('URI');
        $response->assertSee('Web');
        $response->assertSee('Все');
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
        $response->assertSee('Очистить кэш роутов');
        $response->assertSee('Поиск');
        $response->assertSee('Показать');
        $response->assertSee('Приоритет');
        $response->assertSee('Типы маршрутов');
        $response->assertSee('Только');
        $response->assertSee('Устаревшие');
        $response->assertSee('Экшены');
        $response->assertSee('Элементы не найдены');

        $response->assertSee('{0}-{1} из {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }
}
