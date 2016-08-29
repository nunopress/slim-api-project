<?php

return [
    'app.service.templates' => [
        'twig' => [
            'templates_path' => dirname(__DIR__) . '/templates',
            'options' => [
                'cache' => dirname(__DIR__) . '/storage/twig',
                'debug' => false,
                'autoescape' => false
            ],

            'extensions' => [

            ],

            'assets_url' => '/',
            'assets_version' => null
        ]
    ]
];