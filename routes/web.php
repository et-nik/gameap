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
    return redirect('home');
})->middleware('auth');

Route::get('servers', 'ServersController@index')->name('servers');
Route::get('servers/{server}', 'ServersController@show');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('dedicated_servers','Admin\\DedicatedServersController', ['as' => 'admin']);
    Route::resource('servers', 'Admin\\ServersController', ['as' => 'admin']);
    Route::resource('games','Admin\\GamesController', ['as' => 'admin']);
});

Route::group(['prefix' => 'ajax'], function() {
    Route::name('ajax.dedicated_servers.get_ip_list')->get('dedicated_servers/get_ip_list/{dedicated_server}', 'Ajax\\DedicatedServersController@getIpList');
});

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
