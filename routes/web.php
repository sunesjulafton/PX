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
Route::group(['middleware' => 'role:account_owner'], function() {

    Route::get('/home', function() {
 
       return 'Welcome Admin';
       
    });
 
 });
*/


/*
Route::get('/roles', function (Request $request) {

    $user = $request->user();
    dd($user->hasRole('developer')); //will return true, if user has role
    dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
    dd($user->can('create-tasks')); // will return true, if user has permission

    //return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/

//Route::get('/roles', 'PermissionController@Permission');


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/users/create', 'UserController@create');
Route::get('/users', 'UserController@index');
Route::post('/users', 'UserController@store');
//Route::get('/users/{user}', 'UserController@show');
Route::get('/users/{user}/edit', 'UserController@edit');
Route::patch('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@destroy');



Route::get('/websites/create', 'WebsiteController@create');
Route::get('/websites', 'WebsiteController@index');
Route::post('/websites', 'WebsiteController@store');
Route::get('/websites/{website}', 'WebsiteController@show');
Route::get('/websites/{website}/edit', 'WebsiteController@edit');

Route::get('/websites/{website}/manageusers', 'WebsiteController@manageusers');
Route::post('/websites/{website}/manageusers', 'WebsiteController@removeuser');
Route::get('/websites/{website}/inviteuser', 'WebsiteController@inviteuser');
Route::post('/websites/{website}', 'WebsiteController@storeuser');


Route::patch('/websites/{website}', 'WebsiteController@update');
Route::delete('/websites/{website}', 'WebsiteController@destroy');

Route::get('/abtests/create', 'AbtestController@create');
Route::get('/abtests', 'AbtestController@index');
Route::post('/abtests', 'AbtestController@store');