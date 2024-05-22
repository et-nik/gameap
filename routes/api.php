<?php

use Gameap\Http\Controllers\API\ClientCertificatesController;
use Gameap\Http\Controllers\API\DedicatedServersController;
use Gameap\Http\Controllers\API\GameModsController;
use Gameap\Http\Controllers\API\GamesController;
use Gameap\Http\Controllers\API\GdaemonTasksController;
use Gameap\Http\Controllers\API\HealthzController;
use Gameap\Http\Controllers\API\ServersController;
use Gameap\Http\Controllers\API\ServersSettingsController;
use Gameap\Http\Controllers\API\ServersRconController;
use Gameap\Http\Controllers\API\ServersTasksController;
use Gameap\Http\Controllers\API\UsersController;
use Gameap\Services\PersonalAccessTokenService;
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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::name('game_mods.get_mods_list')->get('game_mods/get_list_for_game/{game}', [GameModsController::class, 'getListForGame']);

    Route::middleware('isAdmin')->group(function () {
        // Dedicated servers
        Route::name('dedicated_servers')
            ->get('/dedicated_servers', [DedicatedServersController::class, "list"]);

        Route::name('dedicated_servers.setup')
            ->get('/dedicated_servers/setup', [DedicatedServersController::class, "setup"]);

        Route::name('dedicated_servers.get')
            ->get('/dedicated_servers/{dedicated_server}', [DedicatedServersController::class, "get"]);

        Route::name('dedicated_servers.ip_list')
            ->get('/dedicated_servers/{dedicated_server}/ip_list', [DedicatedServersController::class, "getIpList"]);

        Route::name('dedicated_servers.store')
            ->post('/dedicated_servers', [DedicatedServersController::class, "store"]);

        Route::name('dedicated_servers.update')
            ->put('/dedicated_servers/{id}', [DedicatedServersController::class, "update"]);

        Route::name('dedicated_servers.destroy')
            ->delete('/dedicated_servers/{id}', [DedicatedServersController::class, "destroy"]);

        Route::name('dedicated_servers.busy_ports')
            ->get('/dedicated_servers/{dedicated_server}/busy_ports', [DedicatedServersController::class, "getBusyPorts"]);

        // Client certificates
        Route::name('client_certificates')
            ->get('/client_certificates', [ClientCertificatesController::class, 'list']);

        Route::name('client_certificates.store')
            ->post('/client_certificates', [ClientCertificatesController::class, "store"]);

        Route::name('client_certificates.destroy')
            ->delete('/client_certificates/{id}', [ClientCertificatesController::class, "destroy"]);

        // Users
        Route::name('users')->get('/users', [UsersController::class, 'index']);
        Route::name('users.servers')->get('/users/{id}/servers', [UsersController::class, 'servers']);
        Route::name('users.servers')->get('/users/{id}/servers/{server}/permissions', [UsersController::class, 'serverPermissions']);
        Route::name('users.servers')->put('/users/{id}/servers/{server}/permissions', [UsersController::class, 'saveServerPermission']);
        Route::name('users.store')->post('/users', [UsersController::class, 'store']);
        Route::name('users.show')->get('/users/{id}', [UsersController::class, 'show']);
        Route::name('users.update')->put('/users/{id}', [UsersController::class, 'update']);
        Route::name('users.destroy')->delete('/users/{id}', [UsersController::class, 'destroy']);

        // Games
        Route::name('games')->get('/games', [GamesController::class, 'index']);
        Route::name('games.mods')->get('/games/{game}/mods', [GameModsController::class, 'getListForGame']);
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

    Route::name('servers')->get('servers', [ServersController::class, 'getList']);

    // Servers
    Route::middleware('isAdmin')->group(function () {
        Route::name('servers.search')->get('servers/search',  [ServersController::class, 'search']);

        Route::name('servers.get')
            ->get('servers/{server}', [ServersController::class, 'get']);

        Route::name('servers.store')
            ->post('servers', [ServersController::class, 'store'])
            ->middleware('abilities:' . PersonalAccessTokenService::SERVER_CREATE_ABILITY);

        Route::name('servers.save')
            ->put('servers/{server}', [ServersController::class, 'save'])
            ->middleware('abilities:' . PersonalAccessTokenService::SERVER_CREATE_ABILITY);

        Route::name('servers.destroy')
            ->delete('servers/{server}', [ServersController::class, 'destroy'])
            ->middleware('abilities:' . PersonalAccessTokenService::SERVER_CREATE_ABILITY);
    });

    Route::name('servers.abilities')
        ->get('servers/{server}/abilities', [ServersController::class, 'abilities']);

    Route::name('servers.start')
        ->post('servers/{server}/start', [ServersController::class, 'start'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_START_ABILITY);

    Route::name('servers.stop')
        ->post('servers/{server}/stop', [ServersController::class, 'stop'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_STOP_ABILITY);

    Route::name('servers.restart')
        ->post('servers/{server}/restart', [ServersController::class, 'restart'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_RESTART_ABILITY);

    Route::name('servers.install')
        ->post('servers/{server}/install', [ServersController::class, 'install'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_UPDATE_ABILITY);

    Route::name('servers.update')
        ->post('servers/{server}/update', [ServersController::class, 'update'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_UPDATE_ABILITY);

    Route::name('servers.reinstall')
        ->post('servers/{server}/reinstall', [ServersController::class, 'reinstall'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_UPDATE_ABILITY);

    Route::name('servers.get_status')
        ->get('servers/{server}/status', [ServersController::class, 'getStatus']);

    Route::name('servers.query')
        ->get('servers/{server}/query', [ServersController::class, 'query']);

    Route::name('servers.console')
        ->get('servers/{server}/console', [ServersController::class, 'consoleLog'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_CONSOLE_ABILITY);

    Route::name('servers.send_command')
        ->post('servers/{server}/console', [ServersController::class, 'sendCommand'])
        ->middleware('abilities:' . PersonalAccessTokenService::SERVER_CONSOLE_ABILITY);

    Route::name('servers.get_tasks')->get('servers/{server}/tasks', [ServersTasksController::class, 'getList']);
    Route::name('servers.add_task')->post('servers/{server}/tasks', [ServersTasksController::class, 'store']);
    Route::name('servers.update_task')->put('servers/{server}/tasks/{server_task}', [ServersTasksController::class, 'update']);
    Route::name('servers.delete_task')->delete('servers/{server}/tasks/{server_task}', [ServersTasksController::class, 'destroy']);

    Route::name('servers.get_settings')->get('servers/{server}/settings', [ServersSettingsController::class, 'get']);
    Route::name('servers.save_settings')->put('servers/{server}/settings', [ServersSettingsController::class, 'save']);

    // Rcon
    Route::middleware('abilities:' . PersonalAccessTokenService::SERVER_RCON_CONSOLE_ABILITY)->group(function() {
        Route::name('server.rcon.features')->get('servers/{server}/rcon/features', [ServersRconController::class, 'supportedFeatures']);
        Route::name('server.rcon')->post('servers/{server}/rcon', [ServersRconController::class, 'sendCommand']);

        Route::middleware('abilities:' . PersonalAccessTokenService::SERVER_RCON_PLAYERS_ABILITY)->group(function() {
            Route::name('server.rcon.players')->get('servers/{server}/rcon/players', [ServersRconController::class, 'getPlayers']);
            Route::name('server.rcon.players.kick')->post('servers/{server}/rcon/players/kick', [ServersRconController::class, 'kick']);
            Route::name('server.rcon.players.ban')->post('servers/{server}/rcon/players/ban', [ServersRconController::class, 'ban']);
            Route::name('server.rcon.players.message')->post('servers/{server}/rcon/players/message', [ServersRconController::class, 'message']);
        });
    });

    // Gdaemon tasks
    Route::name('gdaemon_tasks.get')
        ->get('gdaemon_tasks/{gdaemon_task}', [GdaemonTasksController::class, 'get'])
        ->middleware('abilities:' . PersonalAccessTokenService::GDAEMON_TASK_READ_ABILITY);

    Route::name('gdaemon_tasks.output')
        ->get('gdaemon_tasks/{gdaemon_task}/output', [GdaemonTasksController::class, 'output'])
        ->middleware('isAdmin');
});

Route::name("healthz")->get("healthz", [HealthzController::class, 'index']);
