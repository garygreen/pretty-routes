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

/*
  |--------------------------------------------------------------------------
  | Register The Composer Auto Loader
  |--------------------------------------------------------------------------
  |
  | Composer provides a convenient, automatically generated class loader
  | for our application. We just need to utilize it! We'll require it
  | into the script here so that we do not have to worry about the
  | loading of any our classes "manually". Feels great to relax.
  |
 */

require __DIR__ . '/vendor/autoload.php';

/*
  |--------------------------------------------------------------------------
  | Set The Default Timezone
  |--------------------------------------------------------------------------
  |
  | Here we will set the default timezone for PHP. PHP is notoriously mean
  | if the timezone is not explicitly set. This will be used by each of
  | the PHP date and date-time functions throughout the application.
  |
 */

date_default_timezone_set('UTC');
