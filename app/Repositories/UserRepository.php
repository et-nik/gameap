<?php

namespace Gameap\Repositories;

use Gameap\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository extends Repository
{
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
                $user->assignRole(Role::where('id', '=', $role)->firstOrFail());
            }
        }
    }

    /**
     * @param array $fields
     * @param User $user
     */
    public function update(User $user, array $fields)
    {
        if (!$user->update($fields)) {
            return false;
        }

        if (isset($fields['servers'])) {
            $user->servers()->sync($fields['servers']);
        } else {
            $user->servers()->detach();
        }

        if (isset($fields['roles'])) {
            $user->roles()->sync($fields['roles']);
        } else {
            $user->roles()->detach();
        }

        return true;
    }
}