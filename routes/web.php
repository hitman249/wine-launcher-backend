<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/migrate', function () use ($router) {
    \Artisan::call('migrate', ['--path' => 'app/migrations', '--force' => true]);
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->get('config/create', ['uses' => 'ConfigController@create']);
});

$router->get('image/{id}', ['uses' => 'ImageController@get']);
