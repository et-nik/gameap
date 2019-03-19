<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Models\GameMod;
use Illuminate\Support\Str;
use Gameap\Http\Requests\ServerRequest;
use Gameap\Http\Requests\ServerVarsRequest;
use Illuminate\Support\Facades\Auth;

class ServerRepository
{
    protected $model;

    protected $gdaemonTaskRepository;

    public function __construct(Server $server, GdaemonTaskRepository $gdaemonTaskRepository)
    {
        $this->model = $server;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
    }

    public function getAll($perPage = 20)
    {
        $servers = Server::orderBy('id')->with('game')->paginate($perPage);

        return $servers;
    }

    /**
     * Store server
     * 
     * @param array $attributes
     */
    public function store(array $attributes)
    {
        $attributes['uuid'] = Str::orderedUuid()->toString();
        $attributes['uuid_short'] = Str::substr($attributes['uuid'], 0, 8);

        $addInstallTask = false;
        if (isset($attributes['install'])) {
            $attributes['installed'] = ! $attributes['install'];
            $addInstallTask = true;

            unset($attributes['install']);
        }

        if (empty($attributes['start_command'])) {
            $gameMod = GameMod::select('default_start_cmd')->where('id', '=', $attributes['game_mod_id'])->firstOrFail();
            $attributes['start_command'] = $gameMod->default_start_cmd;
        }

        $server = Server::create($attributes);

        if ($addInstallTask) {
            $this->gdaemonTaskRepository->addServerUpdate($server);
        }
    }

    /**
     * Get Servers list for Dedicated server
     *
     * @param int $dedicatedServerId
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

    public function updateVars(Server $server, ServerVarsRequest $request)
    {
        $only = [];
        foreach ($server->gameMod->vars as $var) {
            if ($var['admin_var'] && Auth::user()->cannot('admin roles & permissions')) {
                continue;
            }

            $only[] = 'vars.' . $var['var'];
        }

        $server->update($request->only($only));
    }
}