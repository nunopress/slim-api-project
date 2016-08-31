<?php

/*
 * To help the built-in PHP dev server, check if the request was actually for
 * something which should probably be served as a static file
 */
if ('cli-server' == php_sapi_name() and is_file(__DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']))) {
    return false;
}

/*
 * Define production environment
 */
define('APP_DEBUG', false);

/*
 * Create new application
 */
$app = require_once dirname(__DIR__) . '/shared/app.php';

/*
 * Run the application
 */
$app->run();