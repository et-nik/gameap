<?php

namespace Gameap\Repositories;

use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Services\GlobalApi;
use Symfony\Component\Finder\Glob;

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
     * Upgrade Games and Game Mods using GameAP API
     */
    public function upgradeFromRepo()
    {
        $apiGames = GlobalApi::games();

        foreach ($apiGames as $gameData) {
            $game = Game::firstOrCreate(['code' => $gameData['code']]);

            $game->fill($gameData);
            $game->save();

            if (!empty($gameData['mods'])) {
                foreach ($gameData['mods'] as $gameModData) {
                    $gameMod = GameMod::firstOrCreate(['name' => $gameModData['name']]);
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