<?php

namespace App\Service;

use Interop\Container\ContainerInterface;
use NunoPress\Slim\Provider\Logger\Monolog;
use Slim\Exception\ContainerValueNotFoundException;

/**
 * Class Logger
 * @package App\Service
 */
class Logger
{
    /**
     * @param ContainerInterface $container
     * @return Monolog
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $container->get('config');

        if (null === $config->get('logger', null)) {
            throw new ContainerValueNotFoundException('Logger configuration not found');
        }

        if (null === $config->get('logger.providers.' . $config->get('logger.default'), null)) {
            throw new ContainerValueNotFoundException('Logger default provider configuration missing');
        }

        switch ($config->get('logger.default')) {
            case 'monolog':
                return new Monolog($config->get('logger.providers.monolog.name'), $config->get('logger.providers.monolog.path'), $config->get('logger.providers.monolog.level'));
            break;

            default:
                throw new \RuntimeException('Logger provider not supported');
                break;
        }
    }
}