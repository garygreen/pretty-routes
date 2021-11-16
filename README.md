# Pretty Routes for Laravel

Visualise your routes in pretty format.

<p align="center">
    <img src="/.github/home-page-images/light.png?raw=true" alt="Pretty RoutesLight Theme"/>
</p>

<p align="center">
    <img src="/.github/home-page-images/dark.png?raw=true" alt="Pretty Routes Dark Theme"/>
</p>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

## Installation

### Laravel Framework

To get the latest version of `Pretty Routes`, simply require the project using [Composer](https://getcomposer.org):

```bash
composer require dragon-code/pretty-routes --dev
```

### Lumen Framework

To get the latest version of `Pretty Routes`, simply require the project using [Composer](https://getcomposer.org):

```bash
composer require dragon-code/pretty-routes --dev
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

## Upgrade from another packages

### Upgrade from `andrey-helldar/pretty-routes`

1. In your `composer.json` file, replace `"andrey-helldar/pretty-routes": "^2.0"` with `"dragon-code/pretty-routes": "^3.0"`.
2. Run the command `composer update`.
3. Profit!

### Upgrade from `garygreen/pretty-routes`

6. In your `composer.json` file, replace `"garygreen/pretty-routes": "^1.0"` with `"andrey-helldar/pretty-routes": "^2.0"`.
7. Run the command `composer update`.
8. Profit!

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:      https://img.shields.io/github/workflow/status/TheDragonCode/pretty-routes/phpunit?style=flat-square

[badge_downloads]:  https://img.shields.io/packagist/dt/dragon-code/pretty-routes.svg?style=flat-square

[badge_license]:    https://img.shields.io/packagist/l/dragon-code/pretty-routes.svg?style=flat-square

[badge_stable]:     https://img.shields.io/github/v/release/TheDragonCode/pretty-routes?label=stable&style=flat-square

[badge_unstable]:   https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:       https://github.com/TheDragonCode/pretty-routes/actions

[link_license]:     LICENSE

[link_packagist]:   https://packagist.org/packages/dragon-code/pretty-routes
