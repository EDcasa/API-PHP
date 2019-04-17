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
    return {"id":4,"name":"test","username":"test","email":"test1@tsa.ec","remember_token":null,"api_token":"Lzw2UuVI2APC24l1gbTjYE6SnZm6cYYDnHH7Qfr7bRshVTd1eH4HxjhrMsfm","created_at":"2019-04-08 18:08:14","updated_at":"2019-04-08 18:08:14"}
});

#verify that a user is authenticated
$router->group(['middleware' => ['auth']], function () use ($router){
    $router->get('/users', ['uses' => 'UsersController@index']);
    $router->post('/users', ['uses' => 'UsersController@createdUsers']);
    $router->delete('/users', ['uses' => 'UsersController@deleteUser']);
});
