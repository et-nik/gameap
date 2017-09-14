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

Route::get('servers', 'ServersController@index');
//Route::get('games', 'GamesController@index')->name('games');;
//
//Route::get('games/create', 'GamesController@create');
//Route::post('games', 'GamesController@store');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('dedicated_servers','Admin\\DedicatedServersController', ['as' => 'admin']);
    Route::resource('games','Admin\\GamesController', ['as' => 'admin']);
});

