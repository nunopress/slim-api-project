<?php

/**
 * This file used for change the container to sent to our application.
 *
 * For default we use the Slim Container.
 */

/*
 * Load configuration
 */
$configuration = require_once 'configuration.php';

/*
 * Change slim configuration out of the Slim key for compatibility with
 * the Slim container.
 *
 * todo: We need to found another way to make this.
 */
$slim = $configuration['slim'];
unset($configuration['slim']);

$settings = array_merge($slim, [
    'config' => new \Illuminate\Config\Repository($configuration)
]);

/*
 * Make a container
 */
$container = new \Slim\Container($settings);

/*
 * Return a container
 */
return $container;