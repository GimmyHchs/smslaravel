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

Route::get('/', 'SmsHomeController@index');

//Route::get('home', 'HomeController@index');

$router->resource('home','SmsHomeController');
$router->resource('course','SmsCourselistController');
$router->resource('messagestate','SmsMessagestateController');
$router->resource('setting','SmsSettingController');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
