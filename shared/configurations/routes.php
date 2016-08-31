<?php

return [
    [
        'name' => 'api',
        'path' => '/api[/{name}]',
        'middleware' => App\Controller\API::class,
        'allowed_methods' => ['GET'],
        'rest' => true
    ],

    [
        'name' => 'index',
        'path' => '/[{name}]',
        'middleware' => App\Controller\Index::class,
        'allowed_methods' => ['GET']
    ]
];