<?php

namespace Gameap\Repositories;

use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Services\GlobalApi;
use Symfony\Component\Finder\Glob;
use Illuminate\Support\Arr;

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
        return Game::orderBy('name')->paginate($perPage);
    }

    /**
     * @param string|array $with
     * @param int $perPage
     * @return mixed
     */
    public function allWith($with, $perPage = 20)
    {
        return Game::orderBy('name')->with($with)->paginate($perPage);
    }

    /**
     * Upgrade Games and Game Mods using GameAP API
     */
    public function upgradeFromRepo()
    {
        $apiGames = GlobalApi::games();

        foreach ($apiGames as $gameData) {
            $game = Game::firstOrCreate([
                'code' => $gameData['code'],
                'start_code' => $gameData['start_code'],
                'name' => $gameData['name'],
                'engine' => $gameData['engine'],
            ]);

            $game->fill($gameData);
            $game->save();

            if (!empty($gameData['mods'])) {
                foreach ($gameData['mods'] as $gameModData) {

                    $gameMod = GameMod::firstOrCreate([
                        'name' => $gameModData['name'],
                        'game_code' => $gameData['code']
                    ]);

                    $gameMod->fill($gameModData);

                    if ($gameMod->isValid()) {
                        $gameMod->save();
                    }
                }
            }
        }

        return true;
    }
}