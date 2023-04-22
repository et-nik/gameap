<?php

use Gameap\Http\Controllers\API\DedicatedServersController;
use Gameap\Http\Controllers\API\GameModsController;
use Gameap\Http\Controllers\API\GamesController;
use Gameap\Http\Controllers\API\GdaemonTasksController;
use Gameap\Http\Controllers\API\HealthzController;
use Gameap\Http\Controllers\API\ServersController;
use Gameap\Http\Controllers\API\ServersRconController;
use Gameap\Http\Controllers\API\ServersTasksController;
use Gameap\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::name('game_mods.get_mods_list')->get('game_mods/get_list_for_game/{game}', [GameModsController::class, 'getListForGame']);

Route::middleware('isAdmin')->group(function () {
    Route::name('dedicated_servers.ip_list')
        ->get('dedicated_servers/{dedicated_server}/ip_list', [DedicatedServersController::class, "getIpList"]);

    Route::name('dedicated_servers.busy_ports')
        ->get('dedicated_servers/{dedicated_server}/busy_ports', [DedicatedServersController::class, "getBusyPorts"]);

    // Users
    Route::name('users')->get('/users', [UsersController::class, 'index']);
    Route::name('users.store')->post('/users', [UsersController::class, 'store']);
    Route::name('users.show')->get('/users/{id}', [UsersController::class, 'show']);
    Route::name('users.update')->put('/users/{id}', [UsersController::class, 'update']);
    Route::name('users.destroy')->delete('/users/{id}', [UsersController::class, 'destroy']);

    // Games
    Route::name('games')->get('/games', [GamesController::class, 'index']);
    Route::name('games.store')->post('/games', [GamesController::class, 'store']);
    Route::name('games.show')->get('/games/{game}', [GamesController::class, 'show']);
    Route::name('games.update')->put('/games/{game}', [GamesController::class, 'update']);
    Route::name('games.destroy')->delete('/games/{game}', [GamesController::class, 'destroy']);

    Route::name('game_mods')->get('/game_mods', [GameModsController::class, 'index']);
    Route::name('game_mods.store')->post('/game_mods', [GameModsController::class, 'store']);
    Route::name('game_mods.show')->get('/game_mods/{game_mod}', [GameModsController::class, 'show']);
    Route::name('game_mods.update')->put('/game_mods/{game_mod}', [GameModsController::class, 'update']);
    Route::name('game_mods.destroy')->delete('/game_mods/{game_mod}', [GameModsController::class, 'destroy']);
});

// Servers
Route::middleware('isAdmin')->group(function () {
    Route::name('servers.search')->get('servers/search',  [ServersController::class, 'start']);
    Route::name('servers')->get('servers', [ServersController::class, 'getList']);
});

Route::name('servers.start')->post('servers/start/{server}', [ServersController::class, 'start']);
Route::name('servers.stop')->post('servers/stop/{server}', [ServersController::class, 'stop']);
Route::name('servers.restart')->post('servers/restart/{server}', [ServersController::class, 'restart']);
Route::name('servers.install')->post('servers/install/{server}', [ServersController::class, 'install']);
Route::name('servers.update')->post('servers/update/{server}', [ServersController::class, 'update']);
Route::name('servers.reinstall')->post('servers/reinstall/{server}', [ServersController::class, 'reinstall']);
Route::name('servers.get_status')->get('servers/get_status/{server}', [ServersController::class, 'getStatus']);
Route::name('servers.query')->get('servers/query/{server}', [ServersController::class, 'query']);
Route::name('servers.console')->get('servers/console/{server}', [ServersController::class, 'consoleLog']);
Route::name('servers.send_command')->post('servers/console/{server}', [ServersController::class, 'sendCommand']);

Route::name('servers.get_tasks')->get('servers/{server}/tasks', [ServersTasksController::class, 'getList']);
Route::name('servers.add_task')->post('servers/{server}/tasks', [ServersTasksController::class, 'store']);
Route::name('servers.update_task')->put('servers/{server}/tasks/{server_task}', [ServersTasksController::class, 'update']);
Route::name('servers.delete_task')->delete('servers/{server}/tasks/{server_task}', [ServersTasksController::class, 'destroy']);

// Rcon
Route::name('server.rcon.features')->get('servers/{server}/rcon/features', [ServersRconController::class, 'supportedFeatures']);
Route::name('server.rcon')->post('servers/{server}/rcon', [ServersRconController::class, 'sendCommand']);
Route::name('server.rcon.players')->get('servers/{server}/rcon/players', [ServersRconController::class, 'getPlayers']);
Route::name('server.rcon.players.change_name')->post('servers/{server}/rcon/players/change_name', [ServersRconController::class, 'changeName']);
Route::name('server.rcon.players.message')->post('servers/{server}/rcon/players/message', [ServersRconController::class, 'message']);
Route::name('server.rcon.players.kick')->post('servers/{server}/rcon/players/kick', [ServersRconController::class, 'kick']);
Route::name('server.rcon.players.ban')->post('servers/{server}/rcon/players/ban', [ServersRconController::class, 'ban']);

// Gdaemon tasks
Route::name('gdaemon_tasks.get')->get('gdaemon_tasks/get/{gdaemon_task}', [GdaemonTasksController::class, 'get']);
Route::name('gdaemon_tasks.output')->get('gdaemon_tasks/output/{gdaemon_task}', [GdaemonTasksController::class, 'output']);

Route::name("healthz")->get("healthz", [HealthzController::class, 'index']);
