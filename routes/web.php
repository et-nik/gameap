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

use Gameap\Http\Controllers\Admin\ClientCertificatesController as AdminClientCertificatesController;
use Gameap\Http\Controllers\Admin\DedicatedServersController as AdminDedicatedServersController;
use Gameap\Http\Controllers\Admin\GameModsController as AdminGameModsController;
use Gameap\Http\Controllers\Admin\GamesController as AdminGamesController;
use Gameap\Http\Controllers\Admin\GdaemonTasksController as AdminGdaemonTasksController;
use Gameap\Http\Controllers\Admin\ServersController as AdminServersController;
use Gameap\Http\Controllers\Admin\ServersSettingsController as AdminServersSettingsController;
use Gameap\Http\Controllers\Admin\UsersController as AdminUsersController;
use Gameap\Http\Controllers\Admin\UsersServersPermsController as AdminUsersServersPermsController;
use Gameap\Http\Controllers\GdaemonAPI\SetupController as GdaemonAPISetupController;
use Gameap\Http\Controllers\HomeController;
use Gameap\Http\Controllers\ModulesController;
use Gameap\Http\Controllers\ProfileController;
use Gameap\Http\Controllers\ServersController;
use Gameap\Http\Controllers\TokensController;
use Gameap\Models\Server;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('home');
})->middleware('auth');

Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile', [ProfileController::class, 'changePassword'])->name('profile.change_password');

Route::get('servers', [ServersController::class, 'index'])->name('servers');
Route::get('servers/{server}', [ServersController::class, 'show'])->name('servers.control');
Route::patch('servers/{server}/settings', [ServersController::class, 'updateSettings'])->name('servers.updateSettings');

Route::bind('anyserver', function ($id) {
    return Server::withTrashed()->where('id', $id)->first();
});

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
    Route::resource('client_certificates', AdminClientCertificatesController::class, ['as' => 'admin', 'except' => ['edit']]);
    Route::name('admin.dedicated_servers.download_logs')
        ->get(
            'dedicated_servers/{dedicated_server}/logs.zip',
            [AdminDedicatedServersController::class, 'logsZip'],
        );
    Route::name('admin.dedicated_servers.download_certificates')
        ->get(
            'dedicated_servers/{dedicated_server}/certificates.zip',
            [AdminDedicatedServersController::class, 'certificatesZip'],
        );
    Route::resource('dedicated_servers',AdminDedicatedServersController::class, ['as' => 'admin']);
    Route::resource('servers', AdminServersController::class, ['as' => 'admin']);

    Route::name('admin.games.upgrade')->patch('games/upgrade', [AdminGamesController::class, 'upgrade']);
    Route::resource('games',AdminGamesController::class, ['as' => 'admin']);

    Route::name('admin.users.edit_server_permissions')->get(
        'users/{user}/servers/{server}/edit',
        [AdminUsersServersPermsController::class, 'editPermissions'],
    );
    Route::name('admin.users.update_server_permissions')->patch(
        'users/{user}/servers/{server}/edit',
        [AdminUsersServersPermsController::class, 'updatePermissions'],
    );
    Route::resource('users', AdminUsersController::class, ['as' => 'admin']);

    Route::resource('game_mods', AdminGameModsController::class, ['as' => 'admin']);
    Route::name('admin.game_mods.create')->get('game_mods/create/{game?}', [AdminGameModsController::class, 'create']);

    Route::name('admin.gdaemon_tasks.index')->get('gdaemon_tasks', [AdminGdaemonTasksController::class, 'index']);
    Route::name('admin.gdaemon_tasks.show')->get('gdaemon_tasks/{gdaemon_task}', [AdminGdaemonTasksController::class, 'show']);
    Route::name('admin.gdaemon_tasks.cancel')->post('gdaemon_tasks/{gdaemon_task}/cancel', [AdminGdaemonTasksController::class, 'cancel']);

    Route::name('admin.servers_settings.edit')->get('servers/{server}/settings', [AdminServersSettingsController::class, 'edit']);
    Route::name('admin.servers_settings.update')->patch('servers/{server}/settings',  [AdminServersSettingsController::class, 'update']);
});

Auth::routes([
    'register' => config('app.allow_registration'),
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::get('/report_bug', [HomeController::class, 'reportBug'])->name('report_bug')->middleware('isAdmin');
Route::post('/report_bug', [HomeController::class, 'sendBug'])->name('send_bug')->middleware('isAdmin');
Route::get('/update', [HomeController::class, 'update'])->name('update')->middleware('isAdmin');

Route::get('/modules', [ModulesController::class, 'index'])->name('modules')->middleware('isAdmin');
Route::get('/modules/marketplace', [ModulesController::class, 'marketplace'])->name('modules.marketplace')->middleware('isAdmin');
Route::post('/modules/migrate', [ModulesController::class, 'migrate'])->name('modules.migrate')->middleware('isAdmin');
Route::post('/modules/install', [ModulesController::class, 'install'])->name('modules.install')->middleware('isAdmin');
Route::post('/modules/enable', [ModulesController::class, 'enable'])->name('modules.enable')->middleware('isAdmin');
Route::post('/modules/disable', [ModulesController::class, 'disable'])->name('modules.disable')->middleware('isAdmin');
Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.destroy')->middleware('isAdmin');

Route::name('gdaemon.setup')->get('gdaemon/setup/{token}', [GdaemonAPISetupController::class, 'setup'])->middleware('gdaemonVerifySetupToken');
Route::name('gdaemon.create')->post('gdaemon/create/{token}', [GdaemonAPISetupController::class, 'create'])->middleware('gdaemonVerifyCreateToken');

Route::name('tokens')->get('/tokens', [TokensController::class, 'index']);
Route::name('tokens.generate')->get('/tokens/generate', [TokensController::class, 'generate']);
Route::name('tokens.create')->post('/tokens', [TokensController::class, 'create']);
Route::name('tokens.destroy')->delete('/tokens/{token}', [TokensController::class, 'destroy']);

Route::get('/js/lang/{lang}.js', function ($lang) {
    $strings = Cache::rememberForever('lang/' . $lang . '.js', function () use ($lang) {
        if (!file_exists(resource_path('lang/' . $lang))) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return json_encode($strings);
    });

    return response()->make('window.i18n = ' . $strings . ';', Response::HTTP_OK, ['Content-Type' => 'text/javascript']);
})->name('assets.lang');

Route::get('.well-known/{action}', function (string $action) {
    switch ($action) {
        case 'change-password':
            return response()->redirectToRoute('profile.change_password');
    }

    return response()->redirectToRoute('home');
});
