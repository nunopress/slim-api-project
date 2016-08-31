<?php

namespace NunoPress\Slim\Contract\Controller;

use Interop\Container\ContainerInterface;

/**
 * Class Middleware
 * @package NunoPress\Slim\Contract\Controller
 */
abstract class Middleware
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