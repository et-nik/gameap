<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Helpers\ServerPermissionHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Models\User;
use Gameap\Models\Server;
use Bouncer;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Request;

/**
 * Manage game servers permissions
 * @package Gameap\Http\Controllers\Admin
 */
class UsersServersPermsController extends AuthController
{
    /**
     * The UserRepository instance.
     *
     * @var \Gameap\Repositories\UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPermissions(User $user, Server $server)
    {
        $permissions = $user
            ->getAbilities()
            ->where('entity_type', '=', Server::class)
            ->where('entity_id', '=', $server->id);

        $allPermissions = ServerPermissionHelper::getAllPermissions();

        $checkedPermissions = $permissions->pluck('name')->toArray();

        return view('admin.users.server_perms.edit', [
            'permissions' => $permissions,
            'allPermissions' => $allPermissions,
            'user' => $user,
            'server' => $server,
            'checkedPermissions' => $checkedPermissions,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermissions(Request $request, User $user, Server $server)
    {
        $this->repository->updateServerPermission($user, $server, $request->input('permissions'));
        return redirect()->route('admin.users.edit', $user->id);
    }
}