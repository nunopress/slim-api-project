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
$app = new App\App($container);

/*
 * Load app helpers
 */
require_once dirname(__DIR__) . '/private/helpers.php';

/*
 * Load services
 */
require_once __DIR__ . '/services.php';

/*
 * Load routes
 */
require_once __DIR__ . '/routes.php';

/*
 * Return application
 */
return $app;