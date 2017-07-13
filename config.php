<?php

return [
    /*
     * The endpoint to access the routes.
     */
    'url' => 'routes',

    /*
     * The methods to hide.
     */
    'hide_methods' => [
        'HEAD',
    ],

    /*
     * ignore routes with certain urls through regex
     * ex ('/^something/')
     */
    'ignore_uri' => '',
];
