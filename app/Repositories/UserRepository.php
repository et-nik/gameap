<?php

namespace Gameap\Repositories;

use Bouncer;
use DB;
use Gameap\Helpers\ServerPermissionHelper;
use Gameap\Models\User;
use Gameap\Models\Server;

class UserRepository extends Repository
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll($perPage = 20)
    {
        return User::orderBy('id')->paginate($perPage);
    }

    /**
     * @param array $attributes
     */
    public function store(array $attributes)
    {
        $user = User::create($attributes);

        if (isset($attributes['roles'])) {
            foreach ($attributes['roles'] as &$role) {
                if (Bouncer::role()->where(['name' => $role])->exists()) {
                    $user->assign($role);
                }
            }
            Bouncer::refresh();
        }
    }

    /**
     * @param array $fields
     * @param User $user
     * @return bool
     */
    public function update(User $user, array $fields)
    {
        if (!$user->update($fields)) {
            return false;
        }

        if (isset($fields['servers'])) {
            $user->servers()->sync($fields['servers']);
            DB::table('permissions')
                ->where('entity_id', '=', $user->id)
                ->whereIn('ability_id', function ($query) use ($fields) {
                    $query->select('id')
                        ->from('abilities')
                        ->where('entity_type', '=', Server::class)
                        ->where('entity_id', '=', $fields['servers']);
                })
                ->delete();
        } else {
            $user->servers()->detach();
            DB::table('permissions')
                ->where('entity_id', '=', $user->id)
                ->whereIn('ability_id', function ($query) {
                    $query->select('id')
                        ->from('abilities')
                        ->where('entity_type', '=', Server::class);
                })
                ->delete();
        }

        if (isset($fields['roles'])) {
            $user->assign($fields['roles']);
        } else {
            $user->retract(Bouncer::role()->all());
        }

        Bouncer::refresh();

        return true;
    }

    public function updateServerPermission(User $user, Server $server, array $permissions)
    {
        foreach (ServerPermissionHelper::getAllPermissions() as $pname) {
            if (isset($permissions[$pname]) && $permissions[$pname]) {
                $user->allow($pname, $server);
            } else {
                $user->disallow($pname, $server);
            }
        }

        $user->servers()->syncWithoutDetaching([$server->id]);

        Bouncer::refresh();
    }
}