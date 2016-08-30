<?php

namespace NunoPress\Slim;

/**
 * Class App
 * @package NunoPress\Slim
 */
class App extends \Slim\App
{
    /**
     * @param $pattern
     * @param $name
     * @param MiddlewareController $controller
     * @param array $methods
     * @return $this
     */
    public function resource($pattern, $name, MiddlewareController $controller, array $methods = [])
    {
        /* @todo: rewrite the key association
        $mappedMethods = [
            'GET' => 'index',
            'POST' => 'store',
            'PUT' => 'update',
            'PATCH' => 'update',
            'DELETE' => 'destroy'
        ];*/

        foreach ($methods as $method) {
            $this->map([$method], $pattern, $controller . ':' . strtolower($method))->setName($name . '.' . strtolower($method));
        }

        return $this;
    }
}