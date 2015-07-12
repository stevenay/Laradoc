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
Route::get('/', 'DocumentsController@index');

//Route::get('test', 'ApiSearchController@test');

Route::get('documents/search', 'DocumentsSearchController@index');
Route::get('documents/sync', 'DocumentsController@sync');
Route::resource('documents', 'DocumentsController');

Route::resource('categories', 'CategoriesController');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
