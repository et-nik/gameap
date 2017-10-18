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
     * @param  \Gameap\Http\Requests\UserRequest  $request
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        if (isset($request['roles'])) {
            $roles = $request['roles'];
            
            foreach ($roles as &$role) {
                $user->assignRole(Role::where('id', '=', $role)->firstOrFail());
            }
        }
    }

    /**
     * @param UserRequest $request
     * @param User        $user
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        if (isset($request['roles'])) {
            $user->roles()->sync($request['roles']);  
        }
        else {
            $user->roles()->detach();
        }
    }
}