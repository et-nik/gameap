<?php

namespace Gameap\Repositories;

use Gameap\Helpers\ServerPermissionHelper;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\Bouncer;

class UserRepository
{
    /** @var Bouncer */
    private $bouncer;

    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll(int $perPage = 20)
    {
        return User::orderBy('id')->paginate($perPage);
    }

    /**
     * @param array $attributes
     */
    public function store(array $attributes): User
    {
        $user = User::create($attributes);

        if (isset($attributes['roles'])) {
            foreach ($attributes['roles'] as &$role) {
                if ($this->bouncer->role()->where(['name' => $role])->exists()) {
                    $user->assign($role);
                }
            }
            $this->bouncer->refresh();
        }

        return $user;
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
                ->whereIn('ability_id', function ($query) use ($fields): void {
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
                ->whereIn('ability_id', function ($query): void {
                    $query->select('id')
                        ->from('abilities')
                        ->where('entity_type', '=', Server::class);
                })
                ->delete();
        }

        $user->retract($this->bouncer->role()->all());

        if (isset($fields['roles'])) {
            $user->assign($fields['roles']);
        }

        $this->bouncer->refresh();

        return true;
    }

    public function updateServerPermission(User $user, Server $server, ?array $disabledPermissions): void
    {
        foreach (ServerPermissionHelper::getAllPermissions() as $pname) {
            if (isset($disabledPermissions[$pname]) && $disabledPermissions[$pname]) {
                $this->bouncer->forbid($user)->to($pname, $server);
                $user->disallow($pname, $server);
            } else {
                $this->bouncer->unforbid($user)->to($pname, $server);
                $user->allow($pname, $server);
            }
        }

        $user->servers()->syncWithoutDetaching([$server->id]);

        $this->bouncer->refreshFor($user);
    }

    public function saveServerPermission(User $user, Server $server, array $list): void
    {
        $permissions = collect($list)->keyBy('permission');
        foreach (ServerPermissionHelper::getAllPermissions() as $pname) {
            $isEnabled = $permissions->has($pname) &&
                $permissions->get($pname)['value'];

            if ($isEnabled) {
                $this->bouncer->unforbid($user)->to($pname, $server);
                $user->allow($pname, $server);
            } else {
                $this->bouncer->forbid($user)->to($pname, $server);
                $user->disallow($pname, $server);
            }
        }

        $user->servers()->syncWithoutDetaching([$server->id]);

        $this->bouncer->refreshFor($user);
    }
}
