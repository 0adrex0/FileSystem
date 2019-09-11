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
    return view('pages/index');
});
Route::resource('files', 'FilesController');
Route::post('/files/{id}', 'FilesController@show');

Route::get('/download/{id}', 'FilesController@download');
Route::get('/search', 'FilesController@search');
Route::post('/enter', 'FilesController@directoryenter');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::post('/settings', 'DashboardController@settings');
