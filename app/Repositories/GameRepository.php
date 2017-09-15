<?php

namespace Gameap\Repositories;

use Gameap\Models\Game;

class GameRepository 
{
    public function getAll($perPage = 20)
    {
        return Game::orderBy('code')->paginate($perPage);
    }
}