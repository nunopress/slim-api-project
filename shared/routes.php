<?php

/**
 * This file is a magic system for take the routes from configurations and register automatic.
 */

/*
 * Mount all routes based on configurations
 */
if ($container->has('app.routes') and $routes = $container->get('app.routes') and true === is_array($routes)) {
    foreach ($routes as $route) {
        if (true === isset($route['allowed_methods']) and true === is_array($route['allowed_methods'])) {
            if (true === isset($route['rest']) and true === $route['rest']) {
                $app->resource($route['path'], $route['name'], $route['middleware'], $route['allowed_methods']);
            } else {
                $app->map($route['allowed_methods'], $route['path'], $route['middleware'])->setName($route['name']);
            }
        }
    }
}
