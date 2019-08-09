<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Datatables mode
    |--------------------------------------------------------------------------
    | If is set to true you will see all routes with a datatables
    | instead a normal table. It is set false by default.
    */
    'datatables' => true,

    /*
    |--------------------------------------------------------------------------
    | Turn on or off lights
    |--------------------------------------------------------------------------
    | You will turn on or turn off your lights with this field. Light or dark.
    | If this value is empty, dark is taken by default but with light badges.
    */
    'mode' => 'dark',

    /*
    |--------------------------------------------------------------------------
    | Route name
    |--------------------------------------------------------------------------
    | You can customize this value if you want to change it.
    */
    'name' => 'sweet-routes',

    /*
    |--------------------------------------------------------------------------
    | URL route
    |--------------------------------------------------------------------------
    | The URL to access to routes page.
    */
    'url' => 'routes',

    /*
    |--------------------------------------------------------------------------
    | Middlewares
    |--------------------------------------------------------------------------
    | The middleware/s to apply before attempting to access routes page.
    */
    'middlewares' => [],

    /*
    |--------------------------------------------------------------------------
    | Active when is debugging
    |--------------------------------------------------------------------------
    | Indicates whether to enable sweet routes only when debug is enabled
    | In .env through APP_DEBUG variable.
    */
    'debug_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Obviate methods
    |--------------------------------------------------------------------------
    | Can be hidden methods that are established here..
    */
    'hide_methods' => [
        'HEAD',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hide in groups
    |--------------------------------------------------------------------------
    | A group of routes can be hidden with a regular expression
    */
    'hide_matching' => [
        '#^_debugbar#',
        '#^routes$#',
        '#^prequel#',
        '#^telescope#',
        '#^__clockwork#',
    ],

    /*
    |--------------------------------------------------------------------------
    | Customizer your routes page
    |--------------------------------------------------------------------------
    | Out of the box, this package provides default colors.
    | Customization can be changed with next available variables
    | (with the entire name, hyphens included):
    |
    | --blue: #007bff;
    | --indigo: #6610f2;
    | --purple: #6f42c1;
    | --pink: #e83e8c;
    | --red: #dc3545;
    | --orange: #fd7e14;
    | --yellow: #ffc107;
    | --green: #28a745;
    | --teal: #20c997;
    | --cyan: #17a2b8;
    | --white: #fff;
    | --gray: #6c757d;
    | --gray-dark: #343a40;
    | --primary: #007bff;
    | --secondary: #6c757d;
    | --success: #28a745;
    | --info: #17a2b8;
    | --warning: #ffc107;
    | --danger: #dc3545;
    | --light: #f8f9fa;
    | --dark: #343a40;
    */
    'customizer' => [
        /*'font-color' => '--orange',
        'background-color' => '--dark',
        'strip' => '--red',
        'text-method' => '--red',
        'page-link-active' => '--red',
        'page-link' => '--red',
        'paginate-border' => '--red',
        'paginate-background' => '--orange'*/
    ],
];
