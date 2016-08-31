<?php

namespace NunoPress\Slim\Provider\View;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use NunoPress\Slim\Contract\View\Factory as ViewContract;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Php
 * @package NunoPress\Slim\Provider\View
 */
class Php implements ViewContract, Renderable, Htmlable, Jsonable
{
    /**
     * @var string
     */
    protected $extension = '.php';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $contents;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param string $path
     * @param array $options
     */
    public function __construct($path, array $options = [])
    {
        if (false === is_dir($path)) {
            throw new \RuntimeException('View cannot loading ' . $path . ' because the templates path not exists');
        }

        $this->path = rtrim($path, '/') . '/';
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return $this
     */
    public function fetch(ResponseInterface $response, $template, array $data = [])
    {
        if (false === is_readable($this->path . $template . $this->extension)) {
            throw new \RuntimeException('View cannot render ' . $template . $this->extension . ' because the template not exists');
        }

        $this->response = $response;

        $data = array_merge($this->data, $data);

        ob_start();
        extract($data);
        include($this->path . $template . $this->extension);
        $this->contents = ob_get_clean();

        return $this;
    }

    /**
     * @param string $key
     * @param null|array|string $value
     */
    public function share($key, $value = null)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return int
     */
    public function render()
    {
        return $this->response->getBody()->write($this->contents);
    }

    /**
     * @param int $options
     * @return int
     */
    public function toJson($options = 0)
    {
        return $this->response->withHeader('Content-Type', 'application/json')->getBody()->write(json_encode($this->contents));
    }

    /**
     * @return int
     */
    public function toHtml()
    {
        return $this->response->withHeader('Content-Type', 'text/html')->getBody()->write($this->contents);
    }
}