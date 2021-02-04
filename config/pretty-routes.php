<?php

return [
    /*
     * The endpoint to access the routes.
     */

    'url' => 'routes',

    /*
     * The middleware(s) to apply before attempting to access routes pages (web + api).
     */

    'middlewares' => [],

    /*
     * The middleware(s) to apply before attempting to access WEB route page.
     *
     * Also routes for WEB will be determined by this value.
     */

    'web_middleware' => 'web',

    /*
     * The middleware(s) to apply before attempting to access API route.
     *
     * Also routes for API will be determined by this value.
     */

    'api_middleware' => 'api',

    /*
     * Indicates whether to enable pretty routes only when debug is enabled (APP_DEBUG).
     */

    'debug_only' => true,

    /*
     * The methods to hide.
     */

    'hide_methods' => [
        'HEAD',
    ],

    /*
     * The routes to hide with regular expression
     */

    'hide_matching' => [
        '#^__clockwork#',
        '#^_debugbar#',
        '#^_ignition#',
        '#^horizon#',
        '#^routes#',
        '#^telescope#',
    ],

    /*
     * Set a light or dark themes.
     *
     * Available:
     *   light  - always chooses a light theme.
     *   dark   - always chooses a dark theme.
     *   auto   - automatic theme detection from browser.
     *
     * By default, auto.
     */

    'color_scheme' => 'auto',

    /*
     * If routes are not separated by a domain, this column is hidden from display by default.
     *
     * If you want to always show the column with the domain name, set the value to "true".
     *
     * By default, false.
     */

    'domain_force' => false,

    /*
     * In the case when you need to use a specific localization, set its name to the value.
     *
     * For example "de".
     *
     * Otherwise, leave the value "false".
     */

    'locale_force' => false,
];
