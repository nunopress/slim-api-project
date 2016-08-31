<?php

return [
    'default' => 'twig',

    'providers' => [
        'twig' => [
            'path' => realpath(dirname(__DIR__) . '/views'),

            /*
             * Options passed to Twig_Environment object
             */
            'options' => [
                'cache' => (APP_DEBUG) ? false : realpath(dirname(__DIR__) . '/storage') . DIRECTORY_SEPARATOR . 'views',
                'debug' => (APP_DEBUG) ? true : false,
                'autoescape' => false
            ],

            // todo: added this at runtime in the future releases.
            'extensions' => [

            ],

            /*
             * Integration with Symfony Asset Component
             */
            'assets_url' => '/',
            'assets_version' => null
        ],

        'php' => [
            'path' => realpath(dirname(__DIR__) . '/views')
        ]
    ]
];