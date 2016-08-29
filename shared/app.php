<?php

/**
 * Application bootstrap.
 */

/*
 * Load composer autoloader
 */
require_once dirname(__DIR__) . '/private/vendor/autoload.php';

/*
 * Load container
 */
$container = require_once 'container.php';

/*
 * Make new application
 */
$app = new \NunoPress\Slim\App($container);

/*
 * Load services
 */
require_once __DIR__ . '/services.php';

/*
 * Load routes
 */
require_once __DIR__ . '/routes.php';

//$app->resource('/clear_cache', 'cache', App\Controller\ClearCache::class);

/*
 * Return application
 */
return $app;