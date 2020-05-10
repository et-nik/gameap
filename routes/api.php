<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.dedicated_servers.ip_list')
    ->get('dedicated_servers/{dedicated_server}/ip_list', 'DedicatedServersController@getIpList');

Route::name('api.dedicated_servers.busy_ports')
    ->get('dedicated_servers/{dedicated_server}/busy_ports', 'DedicatedServersController@getBusyPorts');

Route::name('api.game_mods.get_mods_list')->get('game_mods/get_list_for_game/{game}', 'GameModsController@getListForGame');

// Servers
Route::name('api.servers.start')->post('servers/start/{server}', 'ServersController@start');
Route::name('api.servers.stop')->post('servers/stop/{server}', 'ServersController@stop');
Route::name('api.servers.restart')->post('servers/restart/{server}', 'ServersController@restart');
Route::name('api.servers.update')->post('servers/update/{server}', 'ServersController@update');
Route::name('api.servers.reinstall')->post('servers/reinstall/{server}', 'ServersController@reinstall');
Route::name('api.servers.get_status')->get('servers/get_status/{server}', 'ServersController@getStatus');
Route::name('api.servers.query')->get('servers/query/{server}', 'ServersController@query');
Route::name('api.servers.console')->get('servers/console/{server}', 'ServersController@consoleLog');
Route::name('api.servers.send_command')->post('servers/console/{server}', 'ServersController@sendCommand');

Route::name('api.servers.get_tasks')->get('servers/{server}/tasks', 'ServersTasksController@getList');
Route::name('api.servers.add_task')->post('servers/{server}/tasks', 'ServersTasksController@store');
Route::name('api.servers.update_task')->put('servers/{server}/tasks/{server_task}', 'ServersTasksController@update');
Route::name('api.servers.delete_task')->delete('servers/{server}/tasks/{server_task}', 'ServersTasksController@destroy');

// Rcon
Route::name('api.server.rcon.features')->get('servers/{server}/rcon/features', 'ServersRconController@supportedFeatures');
Route::name('api.server.rcon')->post('servers/{server}/rcon', 'ServersRconController@sendCommand');
Route::name('api.server.rcon.players')->get('servers/{server}/rcon/players', 'ServersRconController@getPlayers');
Route::name('api.server.rcon.players.change_name')->post('servers/{server}/rcon/players/change_name', 'ServersRconController@changeName');
Route::name('api.server.rcon.players.message')->post('servers/{server}/rcon/players/message', 'ServersRconController@message');
Route::name('api.server.rcon.players.kick')->post('servers/{server}/rcon/players/kick', 'ServersRconController@kick');
Route::name('api.server.rcon.players.band')->post('servers/{server}/rcon/players/ban', 'ServersRconController@ban');

Route::name('api.servers.search')->get('servers/search', 'ServersController@search')->middleware('isAdmin');

// Gdaemon tasks
Route::name('api.gdaemon_tasks.get')->get('gdaemon_tasks/get/{gdaemon_task}', 'GdaemonTasksController@get');
Route::name('api.gdaemon_tasks.output')->get('gdaemon_tasks/output/{gdaemon_task}', 'GdaemonTasksController@output');