<?php

namespace Gameap\Repositories;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\Server;
use Gameap\Models\GameMod;
use Illuminate\Support\Str;
use Gameap\Http\Requests\ServerVarsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServerRepository
{
    const DEFAULT_RCON_PASSWORD_LENGTH = 10;

    /**
     * @var Server
     */
    protected $model;

    /**
     * @var GdaemonTaskRepository
     */
    protected $gdaemonTaskRepository;

    /**
     * ServerRepository constructor.
     * @param Server $server
     * @param GdaemonTaskRepository $gdaemonTaskRepository
     */
    public function __construct(Server $server, GdaemonTaskRepository $gdaemonTaskRepository)
    {
        $this->model = $server;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll($perPage = 20)
    {
        $servers = Server::orderBy('id')->with('game')->paginate($perPage);

        return $servers;
    }

    /**
     * Store server
     *
     * @param array $attributes
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     */
    public function store(array $attributes)
    {
        $attributes['uuid'] = Str::orderedUuid()->toString();
        $attributes['uuid_short'] = Str::substr($attributes['uuid'], 0, 8);
        
        $attributes['enabled'] = true;
        $attributes['blocked'] = false;

        $addInstallTask = false;
        if (isset($attributes['install'])) {
            $attributes['installed'] = ! $attributes['install'];
            $addInstallTask = true;

            unset($attributes['install']);
        }

        if (empty($attributes['rcon'])) {
             $attributes['rcon'] = Str::random(self::DEFAULT_RCON_PASSWORD_LENGTH);
        }

        $dedicatedServer = DedicatedServer::findOrFail($attributes['ds_id']);

        if (empty($attributes['start_command'])) {
            $gameMod = GameMod::select('default_start_cmd_linux', 'default_start_cmd_windows')->where('id', '=', $attributes['game_mod_id'])->firstOrFail();

            $attributes['start_command'] =
                $dedicatedServer->isLinux()
                    ? $gameMod->default_start_cmd_linux
                    : $gameMod->default_start_cmd_windows;
        }

        if (empty($attributes['dir'])) {
            $attributes['dir'] = 'servers/' . $attributes['uuid'];
        }

        // Fix path. Remove absolute dedicated server path
        $attributes['dir'] = $this->fixPath($attributes['dir'], $dedicatedServer->work_path);

        $server = Server::create($attributes);

        if ($addInstallTask) {
            $this->gdaemonTaskRepository->addServerUpdate($server);
        }
    }

    /**
     * Get Servers list for Dedicated server
     *
     * @param int $dedicatedServerId
     * @return mixed
     */
    public function getServersListForDedicatedServer(int $dedicatedServerId)
    {
        return $this->model->select('*')
            ->where('ds_id', '=', $dedicatedServerId)
            ->get();
    }


    /**
     * Get Servers id list for Dedicated server
     *
     * @param int $dedicatedServerId
     * @return mixed
     */
    public function getServerIdsForDedicatedServer(int $dedicatedServerId)
    {
        return $this->model->select('id')
            ->where('ds_id', '=', $dedicatedServerId)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getServersForAuth()
    {
        if (Auth::user()->can('admin roles & permissions')) {
            return $this->getAll();
        } else {
            return Auth::user()->servers;
        }
    }

    /**
     * @param array $engines
     * @param int|array $dedicatedServers
     * @return \Illuminate\Support\Collection
     */
    public function getServersForEngine(array $engines, $dedicatedServers = [], $excludeIds = [])
    {
        if (is_int($dedicatedServers)) {
            $dedicatedServers = [$dedicatedServers];
        }

        $serversTable = $this->model->getTable();
        $gamesTable = (new Game)->getTable();

        $query = DB::table($serversTable)
            ->selectRaw("{$serversTable}.*, {$gamesTable}.name as game_name")
            ->whereIn('game_id', function($query) use ($engines, $serversTable, $gamesTable) {
                $query->select('code')
                    ->from($gamesTable)
                    ->whereIn('engine', $engines);
            })
            ->join($gamesTable, "{$serversTable}.game_id", '=', "{$gamesTable}.code");

        if (!empty($dedicatedServers)) {
            $query->whereIn('ds_id', $dedicatedServers);
        }

        if (!empty($excludeIds)) {
            $query->whereNotIn('id', $excludeIds);
        }

        return $query->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->model->select(['id', 'name', 'server_ip', 'server_port', 'game_id', 'game_mod_id'])
            ->with(['game' => function($query) {
                $query->select('code','name');
            }])
            ->where('name', 'LIKE', '%' . $query . '%')
            ->get();
    }

    /**
     * @param Server $server
     * @param array  $attributes
     */
    public function update(Server $server, array $attributes)
    {
        $attributes['enabled'] = (bool)array_key_exists('enabled', $attributes);
        $attributes['blocked'] = (bool)array_key_exists('blocked', $attributes);
        $attributes['installed'] = (bool)array_key_exists('installed', $attributes);

        $server->ds_id = $attributes['ds_id'];

        // Fix path. Remove absolute dedicated server path
        $attributes['dir'] = $this->fixPath($attributes['dir'], $server->dedicatedServer->work_path);

        $server->update($attributes);
    }

    /**
     * @param Server            $server
     * @param ServerVarsRequest $request
     */
    public function updateVars(Server $server, ServerVarsRequest $request)
    {
        $only = [];
        foreach ($server->gameMod->vars as $var) {
            if (!empty($var['admin_var']) && Auth::user()->cannot('admin roles & permissions')) {
                continue;
            }

            $only[] = 'vars.' . $var['var'];
        }

        $server->update($request->only($only));
    }

    /**
     * @param $path
     * @param $dsWorkPath
     * @return string
     */
    private function fixPath($path, $dsWorkPath)
    {
        if (substr($path, 0, strlen($dsWorkPath)) == $dsWorkPath) {
            $path = substr($path, strlen($dsWorkPath));
        }

        $path = ltrim($path, '/\\');

        return $path;
    }
}