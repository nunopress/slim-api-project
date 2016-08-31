<?php

/**
 * Setter/Getter configuration values
 *
 * @param string $key
 * @param string $default
 * @return string|array
 */
function config($key, $default = '') {
    global $app;

    $config = $app->getContainer()->get('config');

    return $config->get($key, $default);
}

/**
 * @param \Psr\Http\Message\ResponseInterface $response
 * @param $template
 * @param array $data
 * @return \NunoPress\Slim\Provider\View\Php|\NunoPress\Slim\Provider\View\Twig
 */
function view(Psr\Http\Message\ResponseInterface $response, $template, array $data = []) {
    global $app;

    /** @var \NunoPress\Slim\Provider\View\Php|\NunoPress\Slim\Provider\View\Twig $view */
    $view = $app->getContainer()->get('view');

    return $view->fetch($response, $template, $data);
}

/**
 * @param string $level
 * @param $message
 */
function logger($level = 'info', $message) {
    global $app;

    /** @var \NunoPress\Slim\Provider\Logger\Monolog $logger */
    $logger = $app->getContainer()->get('logger');

    $logger->log($level, $message);
}