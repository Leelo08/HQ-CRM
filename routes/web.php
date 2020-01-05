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
    return view('auth/login');
});


Auth::routes();

Route::resource('company', 'CompanyController');

Route::resource('employee', 'EmployeeController');

Route::get('company/destroy/{id}', 'CompanyController@destroy');

Route::get('employee/destroy/{id}', 'EmployeeController@destroy');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/message', 'MessageController@index');

Route::get('/get_messages', 'MessageController@getMessages');

Route::post('notifications', 'MessageController@sendMail');

Route::get('export/{id}', 'ImportExportController@export')->name('export');

Route::post('import/{id}', 'ImportExportController@import')->name('import');
