<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * The Laravel Default Welcome Page
 */
Route::get('welcome', 'WelcomeController@index');

/**
 * Articles Route
 */
Route:get('/', 'DocumentsController@index');
Route::resource('documents', 'DocumentsController');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
