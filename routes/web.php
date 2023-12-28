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

// routes/api.php

$router->get('/hello', function () use ($router) {
    return response()->json(['message' => 'Hello, World2!']);
});

$router->get('/tasks', 'TasksController@index');
$router->get('/tasks/{id}', 'TasksController@show');
$router->post('/tasks', 'TasksController@store');
$router->put('/tasks/{id}', 'TasksController@update');
$router->delete('/tasks/{id}', 'TasksController@destroy');


