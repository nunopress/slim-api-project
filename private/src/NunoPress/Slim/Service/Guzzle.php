<?php

namespace NunoPress\Slim\Service;

use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;

/**
 * Class Guzzle
 * @package NunoPress\Slim\Service
 */
class Guzzle
{
    /**
     * @param ContainerInterface $container
     * @return Client
     */
    public function __invoke(ContainerInterface $container)
    {
        $params = [];

        if (true === $container->has('app.service.guzzle') and true === is_array($settings = $container->get('app.service.guzzle'))) {
            $params = array_merge($params, $settings);
        }

        return new Client($params);
    }
}