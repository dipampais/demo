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


/*Route::get('/', function () {
    return view('welcome');
});*/


Route::resource('products','ProductController');

Route::resource('projects','ProjectController');

Route::get('/projects/edit/{id}','ProjectController@edit');

Route::post('/projects/edit/{id}','ProjectController@update');