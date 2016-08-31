<?php

namespace App\Service;

use Interop\Container\ContainerInterface;
use NunoPress\Slim\Provider\View\Php;
use NunoPress\Slim\Provider\View\Twig;
use Slim\Exception\ContainerValueNotFoundException;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

/**
 * Class View
 * @package App\Service
 */
class View
{
    /**
     * @param ContainerInterface $container
     * @return Php|Twig
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $container->get('config');

        if (null === $config->get('view', null)) {
            throw new ContainerValueNotFoundException('View configuration not found');
        }

        if (null === $config->get('view.providers.' . $config->get('view.default'), null)) {
            throw new ContainerValueNotFoundException('View default provider configuration missing');
        }

        switch ($config->get('view.default')) {
            case 'php':
                return new Php($config->get('view.providers.php.path'));
            break;

            case 'twig':
                $view = new Twig($config->get('view.providers.twig.path'), $config->get('view.providers.twig.options', []));

                /* todo: move this out of here, but for now the best place */

                /** @var \Twig_Environment $environment */
                $environment = $view->getEnvironment();

                // Integrate with Symfony Asset
                $environment->addFunction(new \Twig_SimpleFunction('asset', function ($path) use ($config) {
                    if (null === $config->get('view.providers.twig.assets_version', null)) {
                        $strategy = new EmptyVersionStrategy();
                    } else {
                        $strategy = new StaticVersionStrategy($config->get('view.providers.twig.assets_version'));
                    }

                    if (null === $config->get('view.providers.twig.assets_url', null)) {
                        $package = new Package($strategy);
                    } else {
                        $package = new PathPackage($config->get('view.providers.twig.assets_url'), $strategy);
                    }

                    return $package->getUrl($path);
                }));

                // Implement best url and path function instead of shit base_url and path_for....
                $environment->addFunction(new \Twig_SimpleFunction('url', function ($url = '/') use ($container) {
                    /*
                     * Remove index.php and index_dev.php if used without built in server
                     */
                    $baseUrl = str_replace(['/index.php', '/index_dev.php'], '', $container->get('request')->getUri()->getBaseUrl());

                    return rtrim($baseUrl . $url, '/');
                }));

                $environment->addFunction(new \Twig_SimpleFunction('path', function ($name, $data = [], $queryParams = [], $appName = 'default') use ($container) {
                    return $container->get('router')->pathFor($name, $data, $queryParams);
                }));

                return $view;
            break;

            default:
                throw new \RuntimeException('View provider not supported');
                break;
        }
    }
}