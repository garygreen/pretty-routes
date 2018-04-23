<?php

return [

    /**
     * The endpoint to access the routes.
     */
    'url' => 'routes',

    /**
     * The middleware(s) to apply before attempting to access routes page.
     */
    'middlewares' => [],

    /**
     * Indicates whether to enable pretty routes only when debug is enabled (APP_DEBUG).
     */
    'debug_only' => true,

    /**
     * The methods to hide.
     */
    'hide_methods' => [
        'HEAD',
    ],

    /**
     * The routes to hide with regular expression.
     *
     * This block determines if a given string matches a given pattern. Asterisks may be used to indicate wildcards.
     */
    'hide_matching' => [
        '_debugbar*',
        'routes*'
    ],

];
