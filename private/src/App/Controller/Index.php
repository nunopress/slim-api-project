<?php

namespace App\Controller;

use NunoPress\Slim\MiddlewareController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Index
 * @package App\Controller
 */
class Index extends MiddlewareController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->getContainer()->get('monolog')->info('App / route');

        return $this->getContainer()->get('twig')->render($response, 'index.twig', $args);
    }
}