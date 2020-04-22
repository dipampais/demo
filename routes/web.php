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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'LoginController@index')->name('login');

Route::post('/login/authenticate', 'LoginController@authenticate')->name('loginauthenticate');

Route::get('/password/reset', 'LoginController@resetPassword')->name('resetPassword');

Route::post('/password/reset', 'LoginController@changePassword')->name('password.update');

Route::get('/register', 'RegisterController@index')->name('register');

Route::post('/register/registerUser', 'RegisterController@registerUser')->name('registerUser');


Route::get('/dashboard', 'DashboardController@index')->name('route.dashboard');

Route::get('/project', 'ProjectController@index')->name('projects');

// Route::group(['middleware' => ['auth']], function() {
//     loginauthenticate
// });