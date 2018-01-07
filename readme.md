Pretty Routes for Laravel 5
====

Visualise your routes in pretty format.

![Pretty Routes](https://raw.githubusercontent.com/garygreen/pretty-routes/master/screenshot.png)

# Installation

```bash
composer require garygreen/pretty-routes
```

If your using autodiscovery in Laravel, it should just work.

Otherwise - add to your `config/app.php` providers array to where all your package providers are (before your app's providers):

```php
PrettyRoutes\ServiceProvider::class,
```

By default the package exposes a `/routes` url. If you wish to make a different configuration or edit views, publish the vendor files:

```bash
php artisan vendor:publish --provider="PrettyRoutes\ServiceProvider"
```

If accessing `/routes` isn't working, ensure that you've included the provider within the same area as all your package providers (before all your app's providers) to ensure it takes priority.

By default pretty routes only enables itself when `APP_DEBUG` env is true. You can configure this on the published config as above, or add any custom middlewares.

If you want rewrite route manually, leave `url` empty and register your own:

```php
Route::get(config('pretty-routes.url'), 'PrettyRoutes\PrettyRoutesController@show')->name('pretty-routes.show');
```