<?php

namespace Gameap\Repositories;

use Gameap\Models\User;

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
}