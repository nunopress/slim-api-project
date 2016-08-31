<?php

/**
 * This file is a magic system for take the services from configurations and register automatic.
 */

/*
 * Register all services based on configurations
 */
if ($container->has('config') and $services = $container->get('config')['services'] and true === is_array($services)) {
    foreach ($services as $name => $class) {
        $container[$name] = new $class($container);
    }
}
