<?php

namespace App\Service;

use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;
use Slim\Exception\ContainerValueNotFoundException;

/**
 * Class HttpClient
 * @package App\Service
 */
class HttpClient
{
    /**
     * @param ContainerInterface $container
     * @return Client
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $container->get('config');

        if (null === $config->get('httpclient', null)) {
            throw new ContainerValueNotFoundException('HttpClient configuration not found');
        }

        if (null === $config->get('httpclient.providers.' . $config->get('httpclient.default'), null)) {
            throw new ContainerValueNotFoundException('HttpClient default provider configuration missing');
        }

        switch ($config->get('view.default')) {
            case 'guzzle':
                return new Client($config->get('httpclient.providers.guzzle'));
                break;

            default:
                throw new \RuntimeException('HttpClient provider not supported');
                break;
        }
    }
}