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
Route::get('/edit/{id}','UsersController@edit')->middleware('auth','checkRole');
Route::post('/edit/{id}','UsersController@edit')->middleware('auth','ckeckRole');

Route::get('/media/{id}','UsersController@media')->middleware('auth','checkRole');
Route::post('/media/{id}','UsersController@media')->middleware('auth','checkRole');

Route::get('/security/{id}','UsersController@security')->middleware('auth','checkRole');
Route::post('/security/{id}','UsersController@security')->middleware('auth','checkRole');

Route::get('/status/{id}','UsersController@status')->middleware('auth','checkRole');
Route::post('/status/{id}','UsersController@status')->middleware('auth','checkRole');


Route::get('/delete/{id}','UsersController@delete')->middleware('auth','checkRole');

Route::get('/createuser','UsersController@createuser')->middleware('auth','admin');
Route::post('/createuser','UsersController@createuser')->middleware('auth','admin');




