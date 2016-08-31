<?php

return [
    'settings' => [
        'displayErrorDetails' => (APP_DEBUG) ? true : false,
        'routerCacheFile' => (APP_DEBUG) ? false : realpath(dirname(__DIR__) . '/storage') . DIRECTORY_SEPARATOR . 'routes.php'
    ]
];