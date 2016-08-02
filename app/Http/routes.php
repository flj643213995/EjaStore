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

Route::get('/','Views\IndexViewController@IndexView');
Route::post('/','Services\IndexController@IndexProductList');

Route::group(['prefix' => 'user'], function () {
	Route::get('login',function(){
		return view('login');
	});
	Route::post('login','Services\UserController@CheckLogin');
});
