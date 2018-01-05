<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__.'/../'))->load();

/*
|--------------------------------------------------------------------------
| Application: Service container
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Standard bindings
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Service providers
|--------------------------------------------------------------------------
*/
$app->register(App\Providers\AppServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

app('config')->set([
    'app.debug' => (true === env('APP_DEBUG'))
]);

return $app;
