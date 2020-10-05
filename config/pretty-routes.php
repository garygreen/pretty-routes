<?php

return [
    /*
     * The endpoint to access the routes.
     */

    'url' => 'routes',

    /*
     * The middleware(s) to apply before attempting to access routes page.
     */

    'middlewares' => [],

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
        '#^_debugbar#',
        '#^_ignition#',
        '#^telescope#',
        '#^routes$#',
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
];
