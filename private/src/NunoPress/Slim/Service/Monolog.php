<?php

namespace NunoPress\Slim\Service;

use Interop\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Exception\ContainerValueNotFoundException;

/**
 * Class Monolog
 * @package NunoPress\Slim\Service
 */
class Monolog
{
    /**
     * @param ContainerInterface $container
     * @return Logger
     * @throws ContainerValueNotFoundException
     */
    public function __invoke(ContainerInterface $container)
    {
        $params = [];

        if (true === $container->has('app.service.logger') and true === is_array($settings = $container->get('app.service.logger'))) {
            $params = array_merge($params, $settings);
        }

        if (false === isset($params['monolog'])) {
            throw new ContainerValueNotFoundException('app.service.logger/monolog settings missing on configuration.');
        }

        $logger = new Logger($params['monolog']['name']);

        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($params['monolog']['path'], $params['monolog']['level']));

        return $logger;
    }
}