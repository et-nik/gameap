<?php

namespace Gameap\Repositories;

use Gameap\Models\Game;

class GameRepository 
{
    protected $model;

    public function __construct(Game $game)
    {
        $this->model = $game;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll($perPage = 20)
    {
        return Game::orderBy('code')->paginate($perPage);
    }
}