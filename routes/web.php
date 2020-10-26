<?php

use App\Http\Controllers\AccountController;

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
$router->get('/account/{accountId}', 'AccountController@show');
$router->post('/account', 'AccountController@store');

// transaction
$router->post('/transaction', 'TransactionController@execute');
$router->post('/transaction/credit', 'TransactionController@executeCredit');
