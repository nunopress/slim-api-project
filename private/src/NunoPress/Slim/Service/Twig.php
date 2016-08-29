<?php

namespace NunoPress\Slim\Service;

use Interop\Container\ContainerInterface;
use Slim\Exception\ContainerValueNotFoundException;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

/**
 * Class Twig
 * @package NunoPress\Slim\Service
 */
class Twig
{
    /**
     * @param ContainerInterface $container
     * @return \Slim\Views\Twig
     */
    public function __invoke(ContainerInterface $container)
    {
        $params = [];

        if (true === $container->has('app.service.templates') and true === is_array($settings = $container->get('app.service.templates'))) {
            $params = array_merge($params, $settings);
        }

        if (false === isset($params['twig'])) {
            throw new ContainerValueNotFoundException('app.service.templates/twig settings missing on configuration.');
        }

        if (false === isset($params['twig']['options'])) {
            $params['twig']['options'] = [];
        }

        $view = new \Slim\Views\Twig($params['twig']['templates_path'], $params['twig']['options']);

        /* todo: removed and implemented url and path instead
        $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');

        $view->addExtension(new TwigExtension($container->get('router'), $basePath));
        */

        $environment = $view->getEnvironment();

        // Integrate with Symfony Asset
        $environment->addFunction(new \Twig_SimpleFunction('asset', function ($path) use ($params) {
            $settings = $params['twig'];

            if (null !== $settings['assets_version']) {
                $strategy = new StaticVersionStrategy($settings['assets_version']);
            } else {
                $strategy = new EmptyVersionStrategy();
            }

            if (! $settings['assets_url']) {
                $package = new Package($strategy);
            } else {
                $package = new PathPackage($settings['assets_url'], $strategy);
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
    }
}