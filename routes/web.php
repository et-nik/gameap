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
Route::post('profile', 'ProfileController@changePassword')->name('profile.change_password');

Route::get('servers', 'ServersController@index')->name('servers');
Route::get('servers/{server}', 'ServersController@show')->name('servers.control');
Route::get('servers/{server}/filemanager', 'ServersController@filemanager')->name('servers.filemanager');
Route::get('servers/{server}/settings', 'ServersController@settings')->name('servers.settings');
Route::patch('servers/{server}/settings', 'ServersController@updateSettings')->name('servers.updateSettings');

Route::bind('anyserver', function ($id) {
    return \Gameap\Models\Server::withTrashed()->where('id', $id)->first();
});

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
    Route::resource('client_certificates','Admin\\ClientCertificatesController', ['as' => 'admin', 'except' => ['edit']]);
    Route::resource('dedicated_servers','Admin\\DedicatedServersController', ['as' => 'admin']);
    Route::resource('servers', 'Admin\\ServersController', ['as' => 'admin']);

    Route::name('admin.games.upgrade')->patch('games/upgrade', 'Admin\\GamesController@upgrade');
    Route::resource('games','Admin\\GamesController', ['as' => 'admin']);

    Route::name('admin.users.edit_server_permissions')->get(
        'users/{user}/servers/{server}/edit',
        'Admin\\UsersServersPermsController@editPermissions'
    );
    Route::name('admin.users.update_server_permissions')->patch(
        'users/{user}/servers/{server}/edit',
        'Admin\\UsersServersPermsController@updatePermissions'
    );
    Route::resource('users','Admin\\UsersController', ['as' => 'admin']);

    Route::resource('game_mods','Admin\\GameModsController', ['as' => 'admin']);
    Route::name('admin.game_mods.create')->get('game_mods/create/{game}', 'Admin\\GameModsController@create');
    
    Route::name('admin.gdaemon_tasks.index')->get('gdaemon_tasks', 'Admin\\GdaemonTasksController@index');
    Route::name('admin.gdaemon_tasks.show')->get('gdaemon_tasks/{gdaemon_task}', 'Admin\\GdaemonTasksController@show');
    Route::name('admin.gdaemon_tasks.cancel')->post('gdaemon_tasks/{gdaemon_task}/cancel', 'Admin\\GdaemonTasksController@cancel');

    Route::name('admin.servers_settings.edit')->get('servers/{server}/settings', 'Admin\\ServersSettingsController@edit');
    Route::name('admin.servers_settings.update')->patch('servers/{server}/settings', 'Admin\\ServersSettingsController@update');
});

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');

Auth::routes([
    'register' => config('app.allow_registration'),
]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/help', 'HomeController@help')->name('help');
Route::get('/report_bug', 'HomeController@reportBug')->name('report_bug');
Route::post('/report_bug', 'HomeController@sendBug')->name('send_bug');
Route::get('/update', 'HomeController@update')->name('update');

Route::get('/modules', 'ModulesController@index')->name('modules')->middleware('isAdmin');
Route::get('/modules/migrate', 'ModulesController@migrate')->name('modules.migrate')->middleware('isAdmin');

Route::name('gdaemon.setup')->get('gdaemon/setup/{token}', 'GdaemonAPI\SetupController@setup')->middleware('gdaemonVerifySetupToken');
Route::name('gdaemon.create')->post('gdaemon/create/{token}', 'GdaemonAPI\SetupController@create')->middleware('gdaemonVerifyCreateToken');

Route::get('/js/lang/{lang}.js', function ($lang) {
    $strings = Cache::rememberForever('lang/' . $lang . '.js', function () use ($lang) {
        if (!file_exists(resource_path('lang/' . $lang))) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
        
        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return json_encode($strings);
    });
    
    return response()->make('window.i18n = ' . $strings . ';', \Illuminate\Http\Response::HTTP_OK, ['Content-Type' => 'text/javascript']);
})->name('assets.lang');