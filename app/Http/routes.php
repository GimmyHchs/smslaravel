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

$router->resource('smshome','SmsHomeController');
$router->resource('sms_courselist','SmsCourselistController');
$router->resource('sms_messagestate','SmsMessagestateController');
$router->resource('sms_setting','SmsSettingController');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
