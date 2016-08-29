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
     * @param $handle
     * @param array $methods
     * @return $this
     */
    public function resource($pattern, $name, $handle, array $methods = [])
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
            $this->map([$method], $pattern, $handle . ':' . strtolower($method))->setName($name . '.' . strtolower($method));
        }

        return $this;
    }
}