<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users','UsersController@users')->middleware('auth');

Route::get('/users/edit/{id}','UsersController@editInfo')->middleware('auth','checkRole');
Route::post('/users/update/{id}','UsersController@updateInfo')->middleware('auth','checkRole');

Route::get('/users/avatar/edit/{id}','UsersController@editAvatar')->middleware('auth','checkRole');
Route::post('/users/avatar/update/{id}','UsersController@updateAvatar')->middleware('auth','checkRole');

Route::get('/users/security/edit/{id}','UsersController@editSecurity')->middleware('auth','checkRole');
Route::post('/users/security/update/{id}','UsersController@updateSecurity')->middleware('auth','checkRole');

Route::get('/users/status/edit/{id}','UsersController@editStatus')->middleware('auth','checkRole');
Route::post('/users/status/update/{id}','UsersController@updateStatus')->middleware('auth','checkRole');


Route::get('/users/delete/{id}','UsersController@deleteUser')->middleware('auth','checkRole');

Route::get('/users/create/edit','UsersController@editUser')->middleware('auth','admin');
Route::post('/users/create','UsersController@createUser')->middleware('auth','admin');




