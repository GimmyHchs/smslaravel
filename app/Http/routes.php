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

Route::get('smshome','SmsHomeController@index');
Route::get('sms_courselist','SmsCourselistController@index');
Route::get('sms_messagestate','SmsMessagestateController@index');
Route::get('sms_setting','SmsSettingController@index'); 

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
