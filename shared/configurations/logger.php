<?php

return [
    'default' => 'monolog',

    'providers' => [
        'monolog' => [
            'name' => 'slim-app',
            'path' => realpath(dirname(__DIR__) . '/storage/') . DIRECTORY_SEPARATOR . ((APP_DEBUG) ? 'app-dev.log' : 'app-prod.log'),
            'level' => (APP_DEBUG) ? Monolog\Logger::DEBUG : \Monolog\Logger::ERROR
        ]
    ]
];