# Slim Framework 3 API Skeleton Project

Use this skeleton project to quickly setup and start working on a new API website.

This project uses the latest Slim version with this services already configured:

- Templates with [Twig](http://twig.sensiolabs.org/) and plain PHP.
- Logger with [Monolog](https://github.com/Seldaek/monolog).
- HTTP Client with [Guzzle](http://guzzlephp.org/).
- Middleware Controllers.
- REST routes registration.
- Configuration files for routes, services and settings powered by [Illuminate Config](https://laravel.com).

This skeleton was built for Composer and this makes setting up a new project quick and easy.

## Install

Run this command from the directory in which you want to create your new project.

    composer create-project nunopress/slim-api-project [my-project-name]

**NOTE:** remember to have in the global path composer or if you use local composer for you project change to `php composer.par` instead of `composer` only.

Replace `[my-project-name]` with the desired directory name for your new project. You'll want to:

- Point your virtual host document root to your new project `public/` directory.
- Ensure `shared/storage/*` is web writable.

## Services

We added the base services for our project's and this working really simple.

### View

We added 2 view renderer: php and Twig.

This Provider working in other way instead Twig View or other Slim View libraries, first we fetch the template and after we choose the output method, this is a example:

```php
$this->getContainer()->get('view')->fetch($response, 'template_name', $data)->toHtml();
```

Or with the shortcut version:

```php
view($response, 'template_name', $data)->toHtml();
```

You have this 2 methods for write the correctly content type and return the response.

We think is much better because you can save the view renderer in a value and based on your project you can write the output.

You can use 2 method for return the output of your templates:

- toHtml: Output in html content type.
- toJson: Output in Json content type.

**NOTE:** We create a shortcut to access to the view object `view($response, $template, $data)`.

#### Twig

Our Twig service working with [Symfony Asset Component](http://symfony.com/doc/current/components/asset.html).

We added `url` method instead to use the default `base_url` from Twig View, this new method can used for make a custom url instead only the base url, example `{{ url('assets/css/style.css') }}` or with Asset Component `{{ url(asset('assets/css/style.css')) }}`.

We also added a short version `path` of `path_for`, the method working as the same of Twig View.

For configure Twig you can following the Twig documentation, we pass the `options` array directly to `Twig_Environment`.

**NOTE:** Remember to use `.twig` extension for your template file and the configuration options found in `providers.twig`.

#### Php

Same as Twig view renderer we added 2 php simple function `url` and `path` and working as proxy same as Twig functions.

**NOTE:** Remember to use `.php` extension for your template file and the configuration options found in `providers.php`.

### Logger

We have included Monolog for save the logs for our projects.

**NOTE:** We create a shortcut for access to logger object `logger($level, $message)`.

#### Monolog

We use Monolog for save the log's for development and production environments. Thanks to the dynamic configuration we have one file (`app-dev.log`) for the development environment and another one (`app-prod.log`) for the production environment.

The configuration is easy to understand, check `shared/configurations/logger.php`.

**NOTE:** Remember to edit the configuration options found in `providers.monolog`.

### HTTP Client

For a moment we made a simple wrapper for Guzzle, in the future releases we can add someone if requested from our clients.

#### Guzzle

We use GuzzleHttp project for calling the HTTP requests. You can configure easy with the configuration file `shared/configurations/httpclient.php`, this configuration passed directly to the `Client` class, for more information's about the options follow the official GuzzleHttp documentation.

**NOTE:** Remember to edit the configuration options found in `providers.guzzle`.

### Middleware Controller

We create abstracted class for our controllers, it's a simple class to inject the DIC inside the controller and you can calling it with `$this->getContainer()` method.

**NOTE:** The default controller called is `App\Controller` in `private/src/App/Controller.php` so if you need you can edit it for make additional functions to your base controller.

To use our abstract class see this example in this project, you can found it in `private/src/App/Controller/Index.php` file:

```php

namespace App\Controller;

use App\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Index
 * @package App\Controller
 */
class Index extends Controller
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        logger('info', 'App / route');

        return view($response, 'index', $args)->toHtml();
    }
}
```

You need to remember to use the `__invoke` method for the Middleware Controller class with the Request/Response/Args parameters, more information's about the [Route Middleware](http://www.slimframework.com/docs/objects/router.html#route-middleware).


### REST Routes Registration

We implemented the `$app->resource($pattern, $name, $controller, array $methods = [])` method for easy mapping one Middleware Controller with the REST features, this working easy and we explain how to do:

For add the `App\Controller\API` class with REST features you need to configure first the routes (`shared/configurations/routes.php`):

```php
return [
    [
        'name' => 'api',
        'path' => '/api',
        'middleware' => App\Controller\API::class,
        'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
        'rest' => true
    ]
];
```

Thanks to the key `rest` we can define the route for use the REST feature. The system register all REST routes defined in the key `allowed_methods` with REST.

The most important to remember is the route name because is automatically assigned with this pattern `{name}.{method}` so in this example the `GET` request is named `api.get` and the `DELETE` request is named `api.delete`.

Someone can think "why use this instead to `any` router method?"; The answer is simple, because with `any` router method you need to write all times the definitions inside the controller instead to mapping correctly into the controller.

For more information's about our routes configuration read later the Routes section. 

### Illuminate Configuration

Thanks to Illuminate Config class we can manage really easy our configuration.

The environment is managed by the constant key `APP_DEBUG` defined inside the `public/index.php` and `public/index_dev.php`.

**NOTE:** We create a shortcut for access to the config object with `config($key, $default = null)` and working in the same way of Laravel helper.

#### Routes

For manage our routes you can edit the configuration file `shared/configurations/routes.php` and following the default route for example (*all default keys are required*):

```php
return [
    [
        'name' => 'api',
        'path' => '/api[/{name}]',
        'middleware' => App\Controller\API::class,
        'allowed_methods' => ['GET'],
        'rest' => true
    ],

    [
        'name' => 'index',
        'path' => '/[{name}]',
        'middleware' => App\Controller\Index::class,
        'allowed_methods' => ['GET']
    ]
];
```

We use all times the Middleware Controller for make more clear our project's so we working fine with this system, we explain how to working:
- name: Used for save the router name, we use sometimes the dotted naming convention, example `auth.login` or `page.contacts`.
- path: The Slim Framework path for define in the routes.
- middleware: Full name with namespace for register inside the DIC, we used the constant because we use IDE for writing our project's.
- allowed_methods: Is an array for every methods and passed this directly to the router map method.
- rest: This key (*boolean value*) is optional and need this when you want use the REST controller (*you find more information's about this in the previous section*).

#### Services

For manage our services you can edit the configuration file `shared/configurations/services.php` and following our base services:

```php
return [
    'view'          => App\Service\View::class,
    'httpclient'    => App\Service\HttpClient::class,
    'logger'        => App\Service\Logger::class
];
```

You can see really easy to understand but we explain, the key is the name saved inside the DIC, the value is a full namespace name of the class. Another times we use the constants for easy developing with IDE.

Example if you want register your PDO service, you can write this `'pdo' => App\Service\Database\PDO::class` and is accessible inside the DIC with `$container->get('pdo')`.

#### View

We use Twig for our views because is easy and fast, but we added the php renderer if you like more this instead of Twig, edit `shared/configurations/view.php` if you need to change the default provider or change providers settings.

```php
return [
    'default' => 'twig',

    'providers' => [
        'twig' => [
            'path' => realpath(dirname(__DIR__) . '/views'),

            /*
             * Options passed to Twig_Environment object
             */
            'options' => [
                'cache' => (APP_DEBUG) ? false : realpath(dirname(__DIR__) . '/storage') . DIRECTORY_SEPARATOR . 'views',
                'debug' => (APP_DEBUG) ? true : false,
                'autoescape' => false
            ],

            // todo: added this at runtime in the future releases.
            'extensions' => [

            ],

            /*
             * Integration with Symfony Asset Component
             */
            'assets_url' => '/',
            'assets_version' => null
        ],

        'php' => [
            'path' => realpath(dirname(__DIR__) . '/views')
        ]
    ]
];
```

Asset Component managed inside the `twig` key because we used with Twig template engine.

You can see the different configuration for the development environment because we don't want the caching and we want enabled the debug:

```php
'twig' => [
    'path' => realpath(dirname(__DIR__) . '/views'),

    /*
     * Options passed to Twig_Environment object
     */
    'options' => [
        'cache' => (APP_DEBUG) ? false : realpath(dirname(__DIR__) . '/storage') . DIRECTORY_SEPARATOR . 'views',
        'debug' => (APP_DEBUG) ? true : false,
        'autoescape' => false
    ],

    // todo: added this at runtime in the future releases.
    'extensions' => [

    ],

    /*
     * Integration with Symfony Asset Component
     */
    'assets_url' => '/',
    'assets_version' => null
]
```

## Project folders

It's really easy to understand but we explain:

- **private**: Inside we found 3 folders, `src`, `tests` and `vendor`. `src` is mapped by composer with namespace by PSR-4, `tests` is used for the phpunit tests and `vendor` is a composer vendor folder.
- **public**: This is a web root folder, you need to configure your Virtual Host to point in this folder for make all other folders out of the web.
- **shared**: This folder have all files that not class, example templates, configurations, bootstrap, cache, logs and more.

## Finish

That's it! Now go build something cool.