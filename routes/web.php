<?php

use Illuminate\Support\Facades\Route;

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

/*

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/


Auth::routes();

Route::get('/', 'HomeController@index');


Route::get('/websites/create', 'WebsiteController@create');
Route::get('/websites', 'WebsiteController@index');
Route::post('/websites', 'WebsiteController@store');
Route::get('/websites/{website}', 'WebsiteController@show');
Route::get('/websites/{website}/edit', 'WebsiteController@edit');
Route::patch('/websites/{website}', 'WebsiteController@update');
Route::delete('/websites/{website}', 'WebsiteController@destroy');

Route::get('/abtests/create', 'AbtestController@create');
Route::get('/abtests', 'AbtestController@index');
Route::post('/abtests', 'AbtestController@store');