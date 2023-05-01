<?php

namespace Gameap\Repositories;

use Gameap\Helpers\PermissionHelper;
use Gameap\Http\Requests\ServerVarsRequest;
use Gameap\Models\Game;
use Gameap\Models\Server;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch;
use Spatie\QueryBuilder\QueryBuilder;

class ServerRepository
{
    public const DEFAULT_RCON_PASSWORD_LENGTH = 10;

    public const DEFAULT_PER_PAGE = 20;

    /** @var Server */
    protected $model;

    /** @var GdaemonTaskRepository */
    protected $gdaemonTaskRepository;

    /** @var Batch */
    protected $mavinooBatch;

    /** @var AuthFactory */
    protected $authFactory;

    /**
     * ServerRepository constructor.
     * @param Server $server
     * @param GdaemonTaskRepository $gdaemonTaskRepository
     */
    public function __construct(
        Server $server,
        GdaemonTaskRepository $gdaemonTaskRepository,
        Batch $mavinooBatch,
        AuthFactory $auth
    ) {
        $this->model                 = $server;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->mavinooBatch          = $mavinooBatch;
        $this->authFactory           = $auth;
    }

    public function find(int $id): Server
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll($perPage = self::DEFAULT_PER_PAGE)
    {
        $servers = Server::orderBy('id')->with('game')->paginate($perPage);

        return $servers;
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
        $currentUser = $this->authFactory->guard()->user();

        if ($currentUser->can(PermissionHelper::ADMIN_PERMISSIONS)) {
            return $this->getAll();
        }

        return $currentUser->servers->paginate(self::DEFAULT_PER_PAGE);
    }

    public function getServersForUser(int $userId)
    {
        $qb = QueryBuilder::for(Server::class)
            ->allowedFilters('ds_id')
            ->with('game:code,name,engine,engine_version')
            ->whereRaw('id IN(SELECT server_id FROM server_user su WHERE su.user_id = ?)', [$userId]);

        return $qb->get([
            'id',
            'uuid',
            'uuid_short',
            'enabled',
            'installed',
            'blocked',
            'name',
            'ds_id',
            'game_id',
            'game_mod_id',
            'server_ip',
            'server_port',
            'query_port',
            'rcon_port',
            'is_online',
        ])->append(['online']);
    }

    public function getAllServers()
    {
        $qb = QueryBuilder::for(Server::class)
            ->allowedFilters('ds_id')
            ->allowedAppends(['full_path', 'is_online'])
            ->with('game:code,name,engine,engine_version');

        return $qb->get([
            'id',
            'uuid',
            'uuid_short',
            'enabled',
            'installed',
            'blocked',
            'name',
            'ds_id',
            'game_id',
            'game_mod_id',
            'server_ip',
            'server_port',
            'query_port',
            'rcon_port',
        ])->append(['online']);
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
        $gamesTable   = (new Game())->getTable();

        $query = DB::table($serversTable)
            ->selectRaw("{$serversTable}.*, {$gamesTable}.name as game_name")
            ->whereIn('game_id', function ($query) use ($engines, $serversTable, $gamesTable): void {
                $query->select('code')
                    ->from($gamesTable)
                    ->whereIn('engine', $engines);
            })
            ->where('deleted_at', null)
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
            ->with(['game' => function ($query): void {
                $query->select('code', 'name');
            }])
            ->where('name', 'LIKE', '%' . $query . '%')
            ->get();
    }

    /**
     * @param Server $server
     * @param array  $attributes
     */
    public function update(Server $server, array $attributes): void
    {
        $attributes['enabled']   = (bool)array_key_exists('enabled', $attributes);
        $attributes['blocked']   = (bool)array_key_exists('blocked', $attributes);
        $attributes['installed'] = (bool)array_key_exists('installed', $attributes);

        if (isset($attributes['ds_id'])) {
            $server->ds_id = $attributes['ds_id'];
        }

        $server->update($attributes);
    }

    /**
     * @param Server            $server
     * @param ServerVarsRequest $request
     */
    public function updateVars(Server $server, ServerVarsRequest $request): void
    {
        $only = [];
        foreach ($server->gameMod->vars as $var) {
            if (!empty($var['admin_var']) && Auth::user()->cannot(PermissionHelper::ADMIN_PERMISSIONS)) {
                continue;
            }

            $only[] = 'vars.' . $var['var'];
        }

        $server->update($request->only($only));
    }

    public function updateSettings(Server $server, ServerVarsRequest $request): void
    {
        $autostartSetting = $server->getSetting($server::AUTOSTART_SETTING_KEY);
        $autostartSetting->value = $request->autostart();
        $autostartSetting->save();

        $autostartCurrentSetting = $server->getSetting($server::AUTOSTART_CURRENT_SETTING_KEY);
        $autostartCurrentSetting->value = $request->autostart();
        $autostartCurrentSetting->save();

        $updateBeforeStartSetting = $server->getSetting($server::UPDATE_BEFORE_START_SETTING_KEY);
        $updateBeforeStartSetting->value = $request->updateBeforeStart();
        $updateBeforeStartSetting->save();
    }

    public function save(Server $server): void
    {
        $server->save();
    }

    public function saveBatch(array $serverValues): void
    {
        $this->mavinooBatch->update(new Server(), $serverValues, 'id');
    }
}
