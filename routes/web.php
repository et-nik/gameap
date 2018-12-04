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

Route::get('profile', 'ProfileController@index')->name('profile');
Route::get('servers', 'ServersController@index')->name('servers');
Route::get('servers/{server}', 'ServersController@show')->name('servers.control');
Route::get('servers/{server}/filemanager', 'ServersController@filemanager')->name('servers.filemanager');

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
    Route::resource('dedicated_servers','Admin\\DedicatedServersController', ['as' => 'admin']);
    Route::resource('servers', 'Admin\\ServersController', ['as' => 'admin']);
    Route::resource('games','Admin\\GamesController', ['as' => 'admin']);
    Route::resource('users','Admin\\UsersController', ['as' => 'admin']);
    Route::resource('game_mods','Admin\\GameModsController', ['as' => 'admin']);
    Route::name('admin.game_mods.create')->get('game_mods/create/{game}', 'Admin\\GameModsController@create', ['as' => 'admin']);
    
    Route::name('admin.gdaemon_tasks.index')->get('gdaemon_tasks', 'Admin\\GdaemonTasksController@index', ['as' => 'admin']);
    Route::name('admin.gdaemon_tasks.show')->get('gdaemon_tasks/{gdaemon_task}', 'Admin\\GdaemonTasksController@show', ['as' => 'admin']);

    Route::name('admin.servers_settings.edit')->get('servers/{server}/settings', 'Admin\\ServersSettingsController@edit', ['as' => 'admin']);
    Route::name('admin.servers_settings.update')->patch('servers/{server}/settings', 'Admin\\ServersSettingsController@update', ['as' => 'admin']);
});

Route::group(['prefix' => 'api'], function() {
    Route::name('api.dedicated_servers.get_ip_list')->get('dedicated_servers/get_ip_list/{dedicated_server}', 'API\\DedicatedServersController@getIpList');
    Route::name('api.game_mods.get_mods_list')->get('game_mods/get_list_for_game/{game}', 'API\\GameModsController@getListForGame');

    // Servers
    Route::name('api.servers.start')->post('servers/start/{server}', 'API\\ServersController@start');
    Route::name('api.servers.stop')->post('servers/stop/{server}', 'API\\ServersController@stop');
    Route::name('api.servers.restart')->post('servers/restart/{server}', 'API\\ServersController@restart');
    Route::name('api.servers.update')->post('servers/update/{server}', 'API\\ServersController@update');
    Route::name('api.servers.get_status')->get('servers/get_status/{server}', 'API\\ServersController@getStatus');
    Route::name('api.servers.query')->get('servers/query/{server}', 'API\\ServersController@query');
    Route::name('api.servers.console')->get('servers/console/{server}', 'API\\ServersController@consoleLog');
    Route::name('api.servers.send_command')->post('servers/console/{server}', 'API\\ServersController@sendCommand');

    // Gdaemon tasks
    Route::name('api.gdaemon_tasks.get')->get('gdaemon_tasks/get/{gdaemon_task}', 'API\\GdaemonTasksController@get');
});

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'gdaemon_api'], function() {

    Route::name('gdaemon_api.get_token')->get('get_token', 'GdaemonAPI\AuthController@getToken');
    // Dedicated servers
    Route::name('gdaemon_api.dedicated_servers.get_init_data')->get('dedicated_servers/get_init_data/{dedicated_server}', 'GdaemonAPI\DedicatedServersController@getInitData');
    
    // Servers
    Route::name('gdaemon_api.servers')->get('servers', 'GdaemonAPI\ServersController@index');
    Route::name('gdaemon_api.servers.server')->get('servers/{server}', 'GdaemonAPI\ServersController@server');
    Route::name('gdaemon_api.servers.update')->put('servers/{server}', 'GdaemonAPI\ServersController@update');

    // GDaemon tasks
    Route::name('gdaemon_api.tasks')->get('tasks', 'GdaemonAPI\TasksController@index');
    Route::name('gdaemon_api.tasks.update')->put('tasks/{gdaemon_task}', 'GdaemonAPI\TasksController@update');
    Route::name('gdaemon_api.tasks.output')->put('tasks/{gdaemon_task}/output', 'GdaemonAPI\TasksController@output');

    // DS Stats
    Route::name('gdaemon_api.ds_stats.store')->post('ds_stats', 'GdaemonAPI\DsStatsController@store');
});
