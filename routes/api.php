<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Gameap\Http\Controllers\API\UsersController;

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

Route::name('dedicated_servers.ip_list')
    ->get('dedicated_servers/{dedicated_server}/ip_list', 'DedicatedServersController@getIpList');

Route::name('dedicated_servers.busy_ports')
    ->get('dedicated_servers/{dedicated_server}/busy_ports', 'DedicatedServersController@getBusyPorts');

Route::name('game_mods.get_mods_list')->get('game_mods/get_list_for_game/{game}', 'GameModsController@getListForGame');

// Users
Route::name('users')->get('/users', [UsersController::class, 'index'])->middleware('isAdmin');
Route::name('users.store')->post('/users', [UsersController::class, 'store'])->middleware('isAdmin');
Route::name('users.show')->get('/users/{id}', [UsersController::class, 'show'])->middleware('isAdmin');
Route::name('users.update')->put('/users/{id}', [UsersController::class, 'update'])->middleware('isAdmin');
Route::name('users.destroy')->delete('/users/{id}', [UsersController::class, 'destroy'])->middleware('isAdmin');

// Servers
Route::name('servers')->get('servers', 'ServersController@getList')->middleware('isAdmin');
Route::name('servers.start')->post('servers/start/{server}', 'ServersController@start');
Route::name('servers.stop')->post('servers/stop/{server}', 'ServersController@stop');
Route::name('servers.restart')->post('servers/restart/{server}', 'ServersController@restart');
Route::name('servers.install')->post('servers/install/{server}', 'ServersController@install');
Route::name('servers.update')->post('servers/update/{server}', 'ServersController@update');
Route::name('servers.reinstall')->post('servers/reinstall/{server}', 'ServersController@reinstall');
Route::name('servers.get_status')->get('servers/get_status/{server}', 'ServersController@getStatus');
Route::name('servers.query')->get('servers/query/{server}', 'ServersController@query');
Route::name('servers.console')->get('servers/console/{server}', 'ServersController@consoleLog');
Route::name('servers.send_command')->post('servers/console/{server}', 'ServersController@sendCommand');

Route::name('servers.get_tasks')->get('servers/{server}/tasks', 'ServersTasksController@getList');
Route::name('servers.add_task')->post('servers/{server}/tasks', 'ServersTasksController@store');
Route::name('servers.update_task')->put('servers/{server}/tasks/{server_task}', 'ServersTasksController@update');
Route::name('servers.delete_task')->delete('servers/{server}/tasks/{server_task}', 'ServersTasksController@destroy');

// Rcon
Route::name('server.rcon.features')->get('servers/{server}/rcon/features', 'ServersRconController@supportedFeatures');
Route::name('server.rcon')->post('servers/{server}/rcon', 'ServersRconController@sendCommand');
Route::name('server.rcon.players')->get('servers/{server}/rcon/players', 'ServersRconController@getPlayers');
Route::name('server.rcon.players.change_name')->post('servers/{server}/rcon/players/change_name', 'ServersRconController@changeName');
Route::name('server.rcon.players.message')->post('servers/{server}/rcon/players/message', 'ServersRconController@message');
Route::name('server.rcon.players.kick')->post('servers/{server}/rcon/players/kick', 'ServersRconController@kick');
Route::name('server.rcon.players.ban')->post('servers/{server}/rcon/players/ban', 'ServersRconController@ban');

Route::name('servers.search')->get('servers/search', 'ServersController@search')->middleware('isAdmin');

// Gdaemon tasks
Route::name('gdaemon_tasks.get')->get('gdaemon_tasks/get/{gdaemon_task}', 'GdaemonTasksController@get');
Route::name('gdaemon_tasks.output')->get('gdaemon_tasks/output/{gdaemon_task}', 'GdaemonTasksController@output');

Route::name("healthz")->get("healthz", "Healthz@index");
