<?php

namespace NunoPress\Slim;

use Interop\Container\ContainerInterface;

/**
 * Class MiddlewareController
 * @package NunoPress\Slim
 */
abstract class MiddlewareController
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}