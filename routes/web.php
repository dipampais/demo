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


Auth::routes(['register' => false]);

Route::get('/', 'LoginController@index')->name('login');

Route::post('/login/authenticate', 'LoginController@authenticate')->name('loginauthenticate');

Route::get('/password/reset', 'LoginController@resetPassword')->name('resetPassword');

Route::post('/password/reset', 'LoginController@changePassword')->name('password.update');

Route::get('/users/registration', 'RegisterController@index')->name('/users/register');

Route::get('/profile', 'ProfileController@editProfile')->name('editProfile');



Route::post('/profile', 'ProfileController@updateProfile')->name('updateProfile');

Route::post('/register/registerUser', 'RegisterController@registerUser')->name('registerUser');


Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::group(['middleware' => ['auth']], function() {
    // Route::get('/dashboard', 'DashboardController@index')->name('route.dashboard');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/project', 'ProjectController@index')->name('projects');
    Route::get('/projectAjaxDatatable', 'ProjectController@indexNew')->name('projectAjaxDatatable');
    Route::resource('projects','ProjectController');
    Route::resource('products','ProductController');
    Route::get('/projects/edit/{id}','ProjectController@edit');
    Route::post('/projects/edit/{id}','ProjectController@update');
    Route::get('/home', 'HomeController@index')->name('home');
});


Auth::routes();
