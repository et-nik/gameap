<?php

namespace Gameap\Repositories;

use Gameap\Models\GameMod;

class GameModRepository
{
    protected $model;

    public function __construct(GameMod $gameMod)
    {
        $this->model = $gameMod;
    }

    public function getAll($perPage = 20)
    {
        return GameMod::orderBy('id')->paginate($perPage);
    }

    /**
     * @param string $gameCode
     * @return array
     */
    public function getIdNameListForGame(string $gameCode)
    {
        return $this->model->select('id', 'name')
            ->where('game_code', '=', $gameCode)
            ->get();
    }
}