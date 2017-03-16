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

Route::get('/', 'TaskController@index');

Auth::routes();

Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@store');
Route::delete('/task/{task}', 'TaskController@destroy');
Route::put('/tasks/{id}', 'TaskController@edit');
