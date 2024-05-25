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

use Gameap\Http\Controllers\API\DedicatedServersController;
use Gameap\Http\Controllers\EmptyController;
use Gameap\Http\Controllers\GdaemonAPI\SetupController as GdaemonAPISetupController;
use Gameap\Models\Server;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('home');
})->middleware('auth');

Route::get('profile', [EmptyController::class, 'empty'])->name('profile');
Route::post('profile', [EmptyController::class, 'empty'])->name('profile.change_password');

Route::get('servers', [EmptyController::class, 'empty'])->name('servers');
Route::get('servers/{server}', [EmptyController::class, 'empty'])->name('servers.control');
Route::patch('servers/{server}/settings', [EmptyController::class, 'empty'])->name('servers.updateSettings');

Route::bind('anyserver', function ($id) {
    return Server::withTrashed()->where('id', $id)->first();
});

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
    Route::resource('client_certificates', EmptyController::class, ['as' => 'admin', 'except' => ['edit']]);
    Route::name('admin.dedicated_servers.download_logs')
        ->get(
            'dedicated_servers/{dedicated_server}/logs.zip',
            [DedicatedServersController::class, 'logsZip'],
        );
    Route::name('admin.dedicated_servers.download_certificates')
        ->get(
            'dedicated_servers/{dedicated_server}/certificates.zip',
            [DedicatedServersController::class, 'certificatesZip'],
        );
    Route::resource('dedicated_servers','EmptyController', ['as' => 'admin']);
    Route::resource('nodes','EmptyController', ['as' => 'admin']);
    Route::resource('servers', 'EmptyController', ['as' => 'admin']);

    Route::name('admin.games.upgrade')->patch('games/upgrade', [EmptyController::class, 'empty']);
    Route::name('admin.games.mod.edit')->get('games/{game}/mods/{game_mod}/edit', [EmptyController::class, 'edit']);
    Route::resource('games',"EmptyController", ['as' => 'admin']);

    Route::name('admin.users.edit_server_permissions')->get(
        'users/{user}/servers/{server}/edit',
        [EmptyController::class, 'editPermissions'],
    );
    Route::name('admin.users.update_server_permissions')->patch(
        'users/{user}/servers/{server}/edit',
        [EmptyController::class, 'updatePermissions'],
    );
    Route::resource('users', EmptyController::class, ['as' => 'admin']);

    Route::resource('game_mods', EmptyController::class, ['as' => 'admin']);
    Route::name('admin.game_mods.create')->get('game_mods/create/{game?}', [EmptyController::class, 'create']);

    Route::name('admin.gdaemon_tasks.index')->get('gdaemon_tasks', [EmptyController::class, 'index']);
    Route::name('admin.gdaemon_tasks.show')->get('gdaemon_tasks/{gdaemon_task}', [EmptyController::class, 'show']);
    Route::name('admin.gdaemon_tasks.cancel')->post('gdaemon_tasks/{gdaemon_task}/cancel', [EmptyController::class, 'empty']);

    Route::name('admin.servers_settings.edit')->get('servers/{server}/settings', [EmptyController::class, 'edit']);
    Route::name('admin.servers_settings.update')->patch('servers/{server}/settings',  [EmptyController::class, 'update']);
});

Auth::routes([
    'register' => config('app.allow_registration'),
]);

Route::get('/home', [EmptyController::class, 'index'])->name('home');
Route::get('/help', [EmptyController::class, 'empty'])->name('help');
Route::get('/report_bug', [EmptyController::class, 'empty'])->name('report_bug')->middleware('isAdmin');
Route::post('/report_bug', [EmptyController::class, 'empty'])->name('send_bug')->middleware('isAdmin');
Route::get('/update', [EmptyController::class, 'empty'])->name('update')->middleware('isAdmin');

Route::get('/modules', [EmptyController::class, 'empty'])->name('modules')->middleware('isAdmin');
Route::get('/modules/marketplace', [EmptyController::class, 'empty'])->name('modules.marketplace')->middleware('isAdmin');
Route::post('/modules/migrate', [EmptyController::class, 'empty'])->name('modules.migrate')->middleware('isAdmin');
Route::post('/modules/install', [EmptyController::class, 'empty'])->name('modules.install')->middleware('isAdmin');
Route::post('/modules/enable', [EmptyController::class, 'empty'])->name('modules.enable')->middleware('isAdmin');
Route::post('/modules/disable', [EmptyController::class, 'empty'])->name('modules.disable')->middleware('isAdmin');
Route::delete('/modules/{module}', [EmptyController::class, 'empty'])->name('modules.destroy')->middleware('isAdmin');

Route::name('gdaemon.setup')->get('gdaemon/setup/{token}', [GdaemonAPISetupController::class, 'setup'])->middleware('gdaemonVerifySetupToken');
Route::name('gdaemon.create')->post('gdaemon/create/{token}', [GdaemonAPISetupController::class, 'create'])->middleware('gdaemonVerifyCreateToken');

Route::name('tokens')->get('/tokens', [EmptyController::class, 'empty']);
Route::name('tokens.generate')->get('/tokens/generate', [EmptyController::class, 'empty']);
Route::name('tokens.create')->post('/tokens', [EmptyController::class, 'empty']);
Route::name('tokens.destroy')->delete('/tokens/{token}', [EmptyController::class, 'empty']);

Route::get('/js/lang/{lang}.js', function ($lang) {
    $strings = Cache::rememberForever('lang/' . $lang . '.js', function () use ($lang) {
        if (!file_exists(resource_path('lang/' . $lang))) {
            $lang = 'en';

            if (!file_exists(resource_path('lang/' . $lang))) {
                abort(Response::HTTP_NOT_FOUND);
            }
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
