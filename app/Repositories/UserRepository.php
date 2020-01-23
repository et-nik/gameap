<?php

namespace Gameap\Repositories;

use Bouncer;
use Gameap\Models\User;

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
        } else {
            $user->servers()->detach();
        }

        if (isset($fields['roles'])) {
            $user->assign($fields['roles']);
        } else {
            $user->retract(Bouncer::role()->all());
        }

        Bouncer::refresh();

        return true;
    }
}