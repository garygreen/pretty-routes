# Pretty Routes for Laravel

Visualise your routes in pretty format.

<p align="center">
    <img src="/.github/home-page-images/light.png?raw=true" alt="Pretty RoutesLight Theme"/>
</p>

<p align="center">
    <img src="/.github/home-page-images/dark.png?raw=true" alt="Pretty Routes Dark Theme"/>
</p>

[![StyleCI Status][badge_styleci]][link_styleci]
[![Github Workflow Status][badge_build]][link_build]
[![For Laravel][badge_laravel]][link_packagist]

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

### Laravel Framework

```bash
composer require andrey-helldar/pretty-routes --dev
```

If your using autodiscovery in Laravel, it should just work.

Otherwise - add to your `config/app.php` providers array to where all your package providers are (before your app's providers):

```php
PrettyRoutes\ServiceProvider::class,
```

### Lumen Framework

```bash
composer require andrey-helldar/pretty-routes --dev
```

In your `bootstrap/app/php` file add a line above `$app->register(App\Providers\RouteServiceProvider::class)`:

```php
if (env('APP_ENV') !== 'production') {
    $app->register(\PrettyRoutes\ServiceProvider::class);
    $app->configure('pretty-routes');
}
```

### Both frameworks

By default, the package exposes a `/routes` url. If you wish to configure this, publish the config.

```bash
php artisan vendor:publish --provider="PrettyRoutes\ServiceProvider"
```

> If accessing `/routes` isn't working, ensure that you've included the provider within the same area as all your package providers (before all your app's providers) to ensure it takes priority.

> By default, pretty routes only enables itself when `APP_DEBUG` env is true. You can configure this on the published config as above, or add any custom middlewares.

## Upgrade from `garygreen/pretty-routes`

1. In your `composer.json` file, replace `"garygreen/pretty-routes"` with `"andrey-helldar/pretty-routes"`.
2. Run the command `composer update`.
3. Profit!

## Compatibility table

| PHP \ Laravel, Lumen | 5.4 | 5.5 | 5.6 | 5.7 | 5.8 | 6.x | 7.x | 8.x |
|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| 7.2 | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x: |
| 7.3 | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: |
| 7.4 | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: |
| 8.0 | :x: | :x: | :x: | :x: | :x: | :white_check_mark: | :white_check_mark: | :white_check_mark: |

[badge_styleci]:    https://styleci.io/repos/130698068/shield

[badge_build]:      https://img.shields.io/github/workflow/status/andrey-helldar/pretty-routes/phpunit?style=flat-square

[badge_laravel]:    https://img.shields.io/badge/Laravel-5.x%20%7C%206.x%20%7C%207.x%20%7C%208.x-orange.svg?style=flat-square

[badge_stable]:     https://img.shields.io/github/v/release/andrey-helldar/pretty-routes?label=stable&style=flat-square

[badge_unstable]:   https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[badge_downloads]:  https://img.shields.io/packagist/dt/andrey-helldar/pretty-routes.svg?style=flat-square

[badge_license]:    https://img.shields.io/packagist/l/andrey-helldar/pretty-routes.svg?style=flat-square

[link_styleci]:     https://github.styleci.io/repos/130698068

[link_build]:       https://github.com/andrey-helldar/pretty-routes/actions

[link_packagist]:   https://packagist.org/packages/andrey-helldar/pretty-routes

[link_license]:     LICENSE
