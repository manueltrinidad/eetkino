<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return view("index", ["name" => "ur mom gay"]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('register', 'UserController@register');
        $router->delete('delete', 'UserController@delete');
    });

    $router->group(['prefix' => 'review'], function () use ($router) {
        $router->get('', 'ReviewController@show');
        $router->post('store', 'ReviewController@store');
        $router->delete('delete', 'ReviewController@delete');
        $router->get('u/{username}', 'ReviewController@showByUsername');
    });

});
