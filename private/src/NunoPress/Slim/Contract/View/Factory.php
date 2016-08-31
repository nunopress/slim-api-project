<?php

namespace NunoPress\Slim\Contract\View;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface Factory
 * @package NunoPress\Slim\Contract\View
 */
interface Factory
{
    /**
     * @param string|array $path
     * @param array $options
     */
    public function __construct($path, array $options = []);

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return $this
     */
    public function fetch(ResponseInterface $response, $template, array $data = []);

    /**
     * @param string $key
     * @param null|string|array $value
     */
    public function share($key, $value = null);
}