<?php

return [
    'app.service.logger' => [
        'monolog' => [
            'path' => dirname(__DIR__) . '/storage/app-dev.log',
            'level' => \Monolog\Logger::DEBUG,
        ]
    ]
];