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
                        ->whereNotIn('entity_id', $fields['servers']);
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

        $user->retract(Bouncer::role()->all());

        if (isset($fields['roles'])) {
            $user->assign($fields['roles']);
        }

        Bouncer::refresh();

        return true;
    }

    public function updateServerPermission(User $user, Server $server, ?array $disabledPermissions)
    {
        foreach (ServerPermissionHelper::getAllPermissions() as $pname) {
            if (isset($disabledPermissions[$pname]) && $disabledPermissions[$pname]) {
                Bouncer::forbid($user)->to($pname, $server);
                $user->disallow($pname, $server);
            } else {
                Bouncer::unforbid($user)->to($pname, $server);
                $user->allow($pname, $server);
            }
        }

        $user->servers()->syncWithoutDetaching([$server->id]);

        Bouncer::refresh();
    }
}