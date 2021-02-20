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
    return view('hello', [
        'siteName' => env('APP_NAME'),
        'siteUrl'  => env('APP_URL'),
    ]);
});

$router->get('image/{id}.jpeg', ['uses' => 'ImageController@get']);

$router->get('check', function () {
    return '';
});

$router->get('/migrate', function () use ($router) {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--path' => 'app/migrations', '--force' => true]);
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->post('user', ['uses' => 'UserController@get']);

    $router->post('config/create', ['uses' => 'ConfigController@create']);
    $router->post('config/update/{id}', ['uses' => 'ConfigController@update']);
    $router->post('config/delete/{id}', ['uses' => 'ConfigController@delete']);
    $router->post('config/select', ['uses' => 'ConfigController@select']);

    $router->post('like/config/{id}', ['uses' => 'LikeController@likeConfig']);
    $router->post('unlike/config/{id}', ['uses' => 'LikeController@unlikeConfig']);
    $router->post('like/image/{id}', ['uses' => 'LikeController@likeImage']);
    $router->post('unlike/image/{id}', ['uses' => 'LikeController@unlikeImage']);
});
