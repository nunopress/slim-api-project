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
 * Make a container
 */
$container = new \Slim\Container($configuration);

/*
 * Return a container
 */
return $container;