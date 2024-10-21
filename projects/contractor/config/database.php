<?php

return [
    'default' => env('DB_CONNECTION', 'contractor'),

    'connections' => [
        'contractor' => [
            'database' => 'contractor',
            'search_path' => 'public',
            'driver' => 'pgsql',
            'host' => 'contractor-postgres',
            'port' => 5432,
            'username' => env('POSTGRES_USERNAME'),
            'password' => env('POSTGRES_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
        ],
        'contractor_testing' => [
            'database' => 'contractor_testing',
            'search_path' => 'public',
            'driver' => 'pgsql',
            'host' => 'contractor-postgres',
            'port' => 5432,
            'username' => env('POSTGRES_USERNAME'),
            'password' => env('POSTGRES_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
        ],
    ],

    'migrations' => 'migrations',
];
