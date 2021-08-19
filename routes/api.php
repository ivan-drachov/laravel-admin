<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use Illuminate\Auth\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users','\App\Http\Controllers\Api\UserController@index');
Route::get('users/{id}', '\App\Http\Controllers\Api\UserController@show');
Route::post('users', '\App\Http\Controllers\Api\UserController@store');
Route::put('users/{id}', '\App\Http\Controllers\Api\UserController@update');
Route::delete('users/{id}', '\App\Http\Controllers\Api\UserController@destroy');
*/
Route::post('login', '\App\Http\Controllers\Api\AuthController@login');
Route::post('register', '\App\Http\Controllers\Api\AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){

    Route::post('logout', '\App\Http\Controllers\Api\AuthController@logout');
    Route::get('chart', '\App\Http\Controllers\Api\DashboardController@chart');
    Route::get('user', '\App\Http\Controllers\Api\UserController@user');
    Route::put('users/info', '\App\Http\Controllers\Api\UserController@updateInfo');
    Route::put('users/password', '\App\Http\Controllers\Api\UserController@updatePassword');
    Route::post('upload', '\App\Http\Controllers\Api\ImageController@upload');
    Route::get('export', '\App\Http\Controllers\Api\OrderController@export');

    Route::apiResource('users', '\App\Http\Controllers\Api\UserController');
    Route::apiResource('roles', '\App\Http\Controllers\Api\RoleController');
    Route::apiResource('products', '\App\Http\Controllers\Api\ProductController');
    Route::apiResource('orders', '\App\Http\Controllers\Api\OrderController')->only('index', 'show');
    Route::apiResource('permissions', '\App\Http\Controllers\Api\PermissionController')->only('index');
});

