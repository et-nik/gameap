<?php

namespace Gameap\Repositories;

use Gameap\Models\User;
use Gameap\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRepository
{
    protected $model;

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
        $user->update($fields);

        if (isset($fields['roles'])) {
            $user->roles()->sync($fields['roles']);
        } else {
            $user->roles()->detach();
        }
    }
}