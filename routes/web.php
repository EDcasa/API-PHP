<?php

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

$router-> post('/users/login', ['uses'=> 'UsersController@getToken']);
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function(){
    //return str_random(32);
    $var = "{'user':'david, 'name':'test'}";
    return json_encode($var);
});

$router->group(['middleware' => 'basic_auth'], function () use ($router) {
    $router->post('users/login', ['uses' => 'UsersController@login']);
});

#verify that a user is authenticated
$router->group(['middleware' => ['auth']], function () use ($router){
    $router->get('/users', ['uses' => 'UsersController@index']);
    $router->post('/users', ['uses' => 'UsersController@createdUsers']);
    $router->delete('/users', ['uses' => 'UsersController@deleteUser']);
});
