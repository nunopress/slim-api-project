<?php

/*
 * This check prevents access to debug front controllers that are deployed by accident to production servers.
 * Feel free to remove this, extend it, or make something more sophisticated.
 */
if (isset($_SERVER['HTTP_CLIENT_IP']) or true === isset($_SERVER['HTTP_X_FORWARDED_FOR']) or false === in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', 'fe80::1', '::1'])) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check ' . basename(__FILE__) . ' for more information.');
}

/*
 * To help the built-in PHP dev server, check if the request was actually for
 * something which should probably be served as a static file
 */
if ('cli-server' == php_sapi_name() and is_file(__DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']))) {
    return false;
}

/*
 * Define development environment
 */
define('APP_ENV', 'dev');

/*
 * Create new application
 */
$app = require_once dirname(__DIR__) . '/shared/app.php';

/*
 * Run the application
 */
$app->run();