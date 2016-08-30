<?php

namespace App\Controller;

use NunoPress\Slim\MiddlewareController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class API
 * @package App\Controller
 */
class API extends MiddlewareController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return mixed
     */
    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->getContainer()->get('monolog')->info('App /api route with REST GET');

        return $response->withJson([
            'code' => 200,
            'message' => 'Json API test',
            'data' => $args
        ]);
    }
}