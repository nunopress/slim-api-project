<?php

return [
    'app.routes' => [
        [
            'name' => 'index',
            'path' => '/[{name}]',
            'middleware' => App\Controller\Index::class,
            'allowed_methods' => ['GET']
        ]
    ]
];