<?php

namespace Gameap\Repositories;

use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Services\GlobalApi;
use Symfony\Component\Finder\Glob;
use Illuminate\Support\Arr;

class GameRepository extends Repository
{
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
    public function allWith($with, $perPage = 50)
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
            $game = Game::find($gameData['code']) ?? new Game();

            $game->fill($gameData);

            if (!$game->save()) {
                return false;
            }

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