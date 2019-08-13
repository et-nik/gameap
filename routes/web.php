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

    Route::name('admin.games.upgrade')->patch('games/upgrade', 'Admin\\GamesController@upgrade', ['as' => 'admin']);
    Route::resource('games','Admin\\GamesController', ['as' => 'admin']);
    Route::resource('users','Admin\\UsersController', ['as' => 'admin']);
    Route::resource('game_mods','Admin\\GameModsController', ['as' => 'admin']);
    Route::name('admin.game_mods.create')->get('game_mods/create/{game}', 'Admin\\GameModsController@create', ['as' => 'admin']);
    
    Route::name('admin.gdaemon_tasks.index')->get('gdaemon_tasks', 'Admin\\GdaemonTasksController@index', ['as' => 'admin']);
    Route::name('admin.gdaemon_tasks.show')->get('gdaemon_tasks/{gdaemon_task}', 'Admin\\GdaemonTasksController@show', ['as' => 'admin']);
    Route::name('admin.gdaemon_tasks.cancel')->post('gdaemon_tasks/{gdaemon_task}/cancel', 'Admin\\GdaemonTasksController@cancel', ['as' => 'admin']);

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
    Route::name('api.servers.reinstall')->post('servers/reinstall/{server}', 'API\\ServersController@reinstall');
    Route::name('api.servers.get_status')->get('servers/get_status/{server}', 'API\\ServersController@getStatus');
    Route::name('api.servers.query')->get('servers/query/{server}', 'API\\ServersController@query');
    Route::name('api.servers.console')->get('servers/console/{server}', 'API\\ServersController@consoleLog');
    Route::name('api.servers.send_command')->post('servers/console/{server}', 'API\\ServersController@sendCommand');

    Route::name('api.servers.search')->get('servers/search', 'API\\ServersController@search')->middleware('isAdmin');

    // Gdaemon tasks
    Route::name('api.gdaemon_tasks.get')->get('gdaemon_tasks/get/{gdaemon_task}', 'API\\GdaemonTasksController@get');
    Route::name('api.gdaemon_tasks.output')->get('gdaemon_tasks/output/{gdaemon_task}', 'API\\GdaemonTasksController@output');
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

Route::get('/modules', 'ModulesController@index', ['middleware' => 'isAdmin'])->name('modules');
Route::get('/modules/migrate', 'ModulesController@migrate', ['middleware' => 'isAdmin'])->name('modules.migrate');

Route::name('gdaemon.setup')->get('gdaemon/setup/{token}', 'GdaemonAPI\SetupController@setup')->middleware('gdaemonVerifySetupToken');
Route::name('gdaemon.create')->post('gdaemon/create/{token}', 'GdaemonAPI\SetupController@create')->middleware('gdaemonVerifyCreateToken');

Route::group(['prefix' => 'gdaemon_api'], function() {

    Route::name('gdaemon_api.get_token')->get('get_token', 'GdaemonAPI\AuthController@getToken');
    // Dedicated servers
    Route::name('gdaemon_api.dedicated_servers.get_init_data')->get('dedicated_servers/get_init_data/{dedicated_server}', 'GdaemonAPI\DedicatedServersController@getInitData');
    
    // Servers
    Route::name('gdaemon_api.servers')->get('servers', 'GdaemonAPI\ServersController@index');
    Route::name('gdaemon_api.servers.server')->get('servers/{anyserver}', 'GdaemonAPI\ServersController@server');
    Route::name('gdaemon_api.servers.update')->put('servers/{anyserver}', 'GdaemonAPI\ServersController@update');
    Route::name('gdaemon_api.servers.bulk_update')->patch('servers', 'GdaemonAPI\ServersController@updateBulk');

    // GDaemon tasks
    Route::name('gdaemon_api.tasks')->get('tasks', 'GdaemonAPI\TasksController@index');
    Route::name('gdaemon_api.tasks.update')->put('tasks/{gdaemon_task}', 'GdaemonAPI\TasksController@update');
    Route::name('gdaemon_api.tasks.output')->put('tasks/{gdaemon_task}/output', 'GdaemonAPI\TasksController@output');

    // DS Stats
    Route::name('gdaemon_api.ds_stats.store')->post('ds_stats', 'GdaemonAPI\DsStatsController@store');
});

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