Pretty Routes for Laravel 5
====

Visualise your routes in pretty format.

# Installation

```
composer require garygreen/pretty-routes
```

Add to your `config/app.php` providers array:

```
"PrettyRoutes\ServiceProvider",
```

By default the package exposes a `/routes` url. If you wish to configure this, publish the config.

```
php artisan vendor:publish
```
