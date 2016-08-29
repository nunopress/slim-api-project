<?php

return [
    'app.service.logger' => [
        'monolog' => [
            'name' => 'slim-app',
            'path' => dirname(__DIR__) . '/storage/app-prod.log',
            'level' => \Monolog\Logger::ERROR,
        ]
    ]
];