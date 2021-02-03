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

$router->get('image/{id}.jpeg', ['uses' => 'ImageController@get']);

$router->get('/migrate', function () use ($router) {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--path' => 'app/migrations', '--force' => true]);
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->post('config/create', ['uses' => 'ConfigController@create']);
    $router->post('config/update/{id}', ['uses' => 'ConfigController@update']);
    $router->post('config/select', ['uses' => 'ConfigController@select']);
});
