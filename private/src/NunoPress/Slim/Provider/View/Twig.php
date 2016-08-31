<?php

namespace NunoPress\Slim\Provider\View;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use NunoPress\Slim\Contract\View\Factory as ViewFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Twig
 * @package NunoPress\Slim\Provider\View
 */
class Twig implements ViewFactory, Renderable, Htmlable, Jsonable
{
    /**
     * @var string
     */
    protected $extension = '.twig';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string|array
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
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @param string|array $path
     * @param array $options
     */
    public function __construct($path, array $options = [])
    {
        if (true === is_string($path)) {
            $path = (array) $path;
        }

        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->environment = new \Twig_Environment($this->loader, $options);
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return $this
     */
    public function fetch(ResponseInterface $response, $template, array $data = [])
    {
        $this->response = $response;

        $data = array_merge($this->data, $data);

        $this->contents = $this->environment->loadTemplate($template . $this->extension)->render($data);

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

    /**
     * @return \Twig_Loader_Filesystem
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @return \Twig_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}