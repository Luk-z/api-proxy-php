<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load application constants
require_once __DIR__ . '/../app/constants.php';

// Load test constants if in testing environment
if (env('APP_ENV') === 'testing' && file_exists(__DIR__ . '/../tests/constants.php')) {
    require_once __DIR__ . '/../tests/constants.php';
}

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

// $app->withFacades();

// $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default file from your vendor directory. You may modify the
| default values as needed.
|
*/

// $app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';

    $customRoutesPath = defined("APP_CUSTOM_ROUTES_PATH") ? APP_CUSTOM_ROUTES_PATH : null;
    if ($customRoutesPath && file_exists($customRoutesPath)) {
        require $customRoutesPath;
    }
});

/*
|--------------------------------------------------------------------------
| Load Custom Includes
|--------------------------------------------------------------------------
|
| Host app can define APP_CUSTOM_INCLUDES_PATH.
| If APP_CUSTOM_INCLUDES_PATH is defined, it is included
| to allow host app to extend controllers, helpers, routes, etc...
|
*/

$customIncludesPath = defined("APP_CUSTOM_INCLUDES_PATH") ? APP_CUSTOM_INCLUDES_PATH : null;
if ($customIncludesPath && file_exists($customIncludesPath)) {
    include_once $customIncludesPath;
}

return $app;
