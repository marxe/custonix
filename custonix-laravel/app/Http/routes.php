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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
  Route::get('users', 'UsersController@create');
  Route::put('users/{id}', 'UsersController@update');
  Route::get('users/{id}', 'UsersController@show');
  Route::delete('users/{id}', 'UsersController@destroy');

  Route::get('categories', 'CategoryController@create');
  Route::post('categories', 'CategoryController@store');
  Route::put('categories/{id}', 'CategoryController@update');
  Route::get('categories/{id}', 'CategoryController@show');
  Route::delete('categories/{id}', 'CategoryController@destroy');

  Route::post('announces', 'AnnounceController@store');
  Route::get('announces/{id}', 'AnnounceController@show');
  Route::delete('announces/{id}','AnnounceController@destroy');

  Route::post('order', 'orderController@order');
  Route::post('requests/{userid}/{itemsid}', 'orderController@requestItem')->where('userid', '[0-9]+')->where('itemid', '[0-9]+');
  Route::get('order', 'orderController@getOrder');
  Route::get('requests/{id}', 'orderController@getRequest');
  Route::put('order/{id}', 'orderController@selectBid');
  Route::put('requests/{id}', 'orderController@statusBar');
  Route::put('order/items/{id}', 'orderController@editOrder');
  Route::get('history/{field}/{fieldid}', 'orderController@history')->where(['field' => '[a-z]+', 'fieldid' => '[0-9]+']);
  Route::delete('order/{id}', 'orderController@deleteOrder');
  Route::delete('request/{id}', 'orderController@deleteRequest');

  Route::post('feedback/{id}', 'privilageController@feedback');
  Route::post('ban/{id}', 'privilageController@setban');
  Route::get('feedback/{id}', 'privilageController@getfeedback');
  Route::get('ban/{id}', 'privilageController@getban');

  Route::get('auth/users', 'HomeController@getUser');

  Route::post('message/{$id}', 'messageController@createMessage');
  Route::get('message/{id}', 'messageController@getMessage');
  Route::delete('message/{id}', 'messageController@deleteMessage');
});



Route::post('login', 'HomeController@doLogin');
Route::post('logout', 'HomeController@doLogout');
Route::post('users', 'HomeController@store');
Route::get('auth/login', 'HomeController@notReg');
