<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Requests\API\Admin\SaveUserServerPermissionsRequest;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Gameap\Http\Controllers\AuthController;
use Gameap\Helpers\ServerPermissionHelper;

class UsersController extends AuthController
{
    /**
     * The UserRepository instance.
     *
     * @var \Gameap\Repositories\UserRepository
     */
    protected $repository;

    /** @var AuthFactory */
    protected $authFactory;

    /**
     * @param  \Gameap\Repositories\UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
        AuthFactory $authFactory
    ) {
        parent::__construct();

        $this->repository = $repository;
        $this->authFactory = $authFactory;
    }

    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user = $this->repository->store($request->all());

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(
            [
                'id' => $user->id,
                'login' => $user->login,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'roles' => $user->roles->pluck('name')
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->repository->update($user, $request->all());

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        if ($currentUser == $id) {
            return response()->json(['message' => __('users.delete_self_error_msg')], 422);
        }

        User::destroy($id);

        return response()->json(null, 204);
    }

    public function servers($id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        return response()->json($user->servers->map(function (Server $server) {
            return [
                'id' => $server->id,
                'uuid' => $server->uuid,
                'uuid_short' => $server->uuid_short,
                'enabled' => $server->enabled,
                'installed' => $server->installed,
                'blocked' => $server->blocked,
                'name' => $server->name,
                'game_id' => $server->game_id,
                'game_mod_id' => $server->game_mod_id,
                'game' => [
                    'code' => $server->game->code,
                    'name' => $server->game->name,
                    'engine' => $server->game->engine,
                    'engine_version' => $server->game->engine_version,
                ],
                'game_mod' => [
                    'id' => $server->gameMod->id,
                    'name' => $server->gameMod->name,
                ],
                'ds_id' => $server->ds_id,
                'expires' => $server->expires,
                'server_ip' => $server->server_ip,
                'server_port' => $server->server_port,
                'query_port' => $server->query_port,
                'rcon_port' => $server->rcon_port,
            ];
        }));
    }

    public function serverPermissions($id, Server $server)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $allPermissions = ServerPermissionHelper::getAllPermissions();

        $permissions = [];

        foreach ($allPermissions as $permission) {
            $permissions[] = [
                'permission' => $permission,
                'value'      => $user->can($permission, $server),
                'name'       => __('users.permission_names.' . $permission),
            ];
        }

        return response()->json($permissions);
    }

    public function saveServerPermission(SaveUserServerPermissionsRequest $request, $id, Server $server)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $permissions = $request->all();

        $this->repository->saveServerPermission($user, $server, $permissions);

        return response()->json(['message' => 'success'], 204);
    }
}
