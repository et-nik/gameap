<?php

Route::name('get_token')->get('get_token', 'AuthController@getToken');

// Dedicated servers
Route::name('dedicated_servers.get_init_data')->get(
    'dedicated_servers/get_init_data/{dedicated_server}',
    'DedicatedServersController@getInitData'
);

// Servers
Route::name('servers')->get('servers', 'ServersController@index');
Route::name('servers.server')->get('servers/{anyserver}', 'ServersController@server');
Route::name('servers.update')->put('servers/{anyserver}', 'ServersController@update');
Route::name('gservers.bulk_update')->patch('servers', 'ServersController@updateBulk');

// Servers Tasks
Route::name('servers_tasks')->get('servers_tasks', 'ServersTasksController@getList');
Route::name('servers_tasks.get')->get('servers_tasks/{server_task}', 'ServersTasksController@get');
Route::name('servers_tasks.fail')->post('servers_tasks/{server_task}/fail', 'ServersTasksController@fail');
Route::name('servers_tasks.update')->put('servers_tasks/{server_task}', 'ServersTasksController@update');

// GDaemon tasks
Route::name('tasks')->get('tasks', 'TasksController@index');
Route::name('tasks.update')->put('tasks/{gdaemon_task}', 'TasksController@update');
Route::name('tasks.output')->put('tasks/{gdaemon_task}/output', 'TasksController@output');

// DS Stats
Route::name('ds_stats.store')->post('ds_stats', 'DsStatsController@store');