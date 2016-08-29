# Slim Framework 3 API Skeleton Project

Use this skeleton project to quickly setup and start working on a new API website.

This project uses the latest Slim version with this services already configured:

- Templates with [Twig](http://twig.sensiolabs.org/)
- Logger with [Monolog](https://github.com/Seldaek/monolog)
- [Guzzle](http://guzzlephp.org/) for HTTP Client
- Middleware Controllers
- REST routes registration
- Dynamic configuration files for routes, services and settings

This skeleton was built for Composer and this makes setting up a new project quick and easy.

## Install

Run this command from the directory in which you want to create your new project.

    php composer.phar create-project nunopress/slim-api-project [my-project-name]

Replace `[my-project-name]` with the desired directory name for your new project. You'll want to:

- Point your virtual host document root to your new project `public/` directory.
- Ensure `shared/storage/*` is web writeable.

## Services

We added the base services for our project's and this working really simple.

### Twig

Our Twig service working with proxy of [Slim Twig View](https://github.com/slimphp/Twig-View) but we modified for working much better with [Symfony Asset Component](http://symfony.com/doc/current/components/asset.html).

We added `url` method instead to use the default `base_url` from Twig View, this new method can used for make a custom url instead only the base url, example:

    `{{ url('assets/css/style.css') }}` or with Asset Component `{{ url(asset('assets/css/style.css')) }}`.

We also added a short version `path` of `path_for`, the method working as the same of Twig View (*we think to remove the Twig View in the future releases for this we added this 2 methods*).

For configure Twig you can following the Twig documentation, we pass the `options` array directly to `Twig_Environment`.

### Monolog

We use Monolog for save the log's for development and production environments. Thanks to the dynamic configuration we have one file (`app-dev.log`) for the development environment and another one (`app-prod.log`) for the production environment.

The configuration is easy to understand, check `shared/configurations/logger.global.php` for production environment and `shared/configurations/logger.local.php` for development environment.

### Guzzle

We use GuzzleHttp project for calling the HTTP requests. You can configure easy with the configuration file `shared/configurations/guzzle.global.php`, this configuration passed directly to the `Client` class, for more informations about the options follow the official GuzzleHttp documentation.

### Middleware Controller

We create abstracted class for our controllers, it's a simple class to inject the DIC inside the controller and you can calling it with `$this->getContainer()` method.

To use our abstract class see this example in this project (you can found it in `private/src/App/Controller/Index.php` file):

```
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
     * @param $args
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->getContainer()->get('monolog')->info('App / route');

        return $this->getContainer()->get('twig')->render($response, 'index.twig', $args);
    }
}
```

You need to remember to use the `__invoke` method for the Middleware Controller class with the Request/Response/Args parameters, more informations about the [Route Middleware](http://www.slimframework.com/docs/objects/router.html#route-middleware).


### REST Routes Registration

We implemented the `$app->resource()` method for easy mapping one Middleware Controller with the REST features, this working easy and we explain how to do:

For add the `App\Controller\API` class with REST features you need to configure first the routes (`shared/configurations/routes.global.php`):

```
return [
    'app.routes' => [
        [
            'name' => 'api',
            'path' => '/api',
            'middleware' => App\Controller\API::class,
            'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
            'rest' => true
        ]
    ]
];
```

Thanks to the key `rest` we can define the route for use the REST feature. The system register all REST routes defined in the key `allowed_methods` with REST.

The most important to remember is the route name because is automatically assigned with this pattern `{name}.{method}` so in this example the `GET` request is named `api.get` and the `DELETE` request is named `api.delete`.

Someone can think "why use this instead to `any` router method?"; The answer is simple, because with `any` router method you need to write all times the definitions inside the controller instead to mapping correctly into the controller.

For more information's about our routes configuration read later the Routes section. 

### Dynamic Configuration

Thanks to our dynamic configuration is easy to manage routes, services and settings. Our configurator read **FIRST** the `global` files and then if you use the development environment read the `local` files. We use `array_replace_recursive` for replace the keys so you can make a really different configuration for production and development environment.

The environment is managed by the constant key `APP_ENV` defined inside the `public/index.php` and `public/index_dev.php`.

#### Routes

For manage our routes you can edit the configuration file `shared/configurations/routes.global.php` and following the default route for example (*all default keys are required*):

```
return [
    'app.routes' => [
        [
            'name' => 'index',
            'path' => '/[{name}]',
            'middleware' => App\Controller\Index::class,
            'allowed_methods' => ['GET']
        ]
    ]
];
```

We use all times the Middleware Controller for make more clear our project's so we working fine with this system, we explain how to working:
- name: Used for save the router name, we use sometimes the dotted naming convension, example `auth.login` or `page.contacts`.
- path: The Slim Framework path for define in the routes.
- middleware: Full name with namespace for register inside the DIC, we used the constant because we use IDE for writing our project's.
- allowed_methods: Is an array for every methods and passed this directly to the router map method.
- rest: This key (*boolean value*) is optional and need this when you want use the REST controller (*you find more information's about this in the previous section*).

#### Services

For manage our services you can edit the configuration file `shared/configurations/services.global.php` and following our base services:

```
return [
    'app.services' => [
        'twig' => NunoPress\Slim\Service\Twig::class,
        'guzzle' => NunoPress\Slim\Service\Guzzle::class,
        'monolog' => NunoPress\Slim\Service\Monolog::class
    ]
];
```

You can see really easy to understand but we explain, the key is the name saved inside the DIC, the value is a full namespace name of the class. Another times we use the constants for easy developing with IDE.

Example if you want register your PDO service, you can write this `'pdo' => App\Service\PDO::class` and is accessible inside the DIC with `$container->get('pdo')`.

#### Templates

We use Twig for our template engine because is easy and fast. You can configure with different configurations from the current environment, for production environment edit `shared/configurations/templates.global.php` and for development environment edit `shared/configurations/templates.local.php`.

```
return [
    'app.service.templates' => [
        'twig' => [
            'templates_path' => dirname(__DIR__) . '/templates',
            'options' => [
                'cache' => dirname(__DIR__) . '/storage/twig',
                'debug' => false,
                'autoescape' => false
            ],

            'extensions' => [

            ],

            'assets_url' => '/',
            'assets_version' => null
        ]
    ]
];
```

Asset Component managed inside the `twig` key because we used with Twig template engine.

You can see the different configuration for the development environment because we don't want the caching and we want enabled the debug:

```
return [
    'app.service.templates' => [
        'twig' => [
            'options' => [
                'cache' => false,
                'debug' => true
            ]
        ]
    ]
];
```

## Project folders

It's really easy to understand but we explain:

- private: Inside we found 3 folders, `src`, `tests` and `vendor`. `src` is mapped by composer with namespace by PSR-4, `tests` is used for the phpunit tests and `vendor` is a composer vendor folder.
- public: This is a web root folder, you need to configure your Virtual Host to point in this folder for make all other folders out of the web.
- shared: This folder have all files that not class, example templates, configurations, bootstrap, cache, logs and more.

## Finish

That's it! Now go build something cool.