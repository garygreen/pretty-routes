<?php

return [

    /**
     * The endpoint to access the routes.
     */
    'url' => 'routes',

    /**
     * The methods to hide.
     */
    'hide_methods' => [
        'HEAD',
    ],

    /**
     * The routes to hide with a regular expression. (Without delimiters)
     */
    'hide_matching' => [
        '^_debugbar',
    ],

];
