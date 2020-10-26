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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// Route::apiResource('photos', AccountController::class);
$router->get('/account/{accountId}', 'AccountController@show');
$router->post('/account', 'AccountController@store');

// transaction
$router->post('/transaction', 'TransactionController@execute');
$router->post('/transaction/credit', 'TransactionController@executeCredit');

// account
// $router->group(['prefix' => 'account'], function () use ($router) {
//     $router->get('/{accountId}', [AccountController::class, "show"]);

//     $router->post('/', function () {
//         // Matches The "/account/users" URL
//     });

//     $router->patch('/{accountId}', function () {
//         // Matches The "/account/users" URL
//     });
// });


// // transaction
// $router->group(['prefix' => 'transaction'], function () use ($router) {
//     $router->get('/{transactionId}', function () {
//         // Matches The "/transaction/users" URL
//     });

//     $router->post('/', function () {
//         // Matches The "/transaction/users" URL
//     });

//     $router->path('/{transactionId}', function () {
//         // Matches The "/transaction/users" URL
//     });
// });
