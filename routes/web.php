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

Route::get('/', function () {
    return view('welcome');
});

Route::get('main/get_data', 'MainController@showData')->name('main.show.data');
Route::get('main', 'MainController@index')->name('main.index');
Route::post('main/create_user', 'MainController@createUser')->name('main.create.user');
