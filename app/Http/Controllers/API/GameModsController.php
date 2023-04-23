<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\GameModRepository;
use Gameap\Models\GameMod;
use Illuminate\Http\Request;

class GameModsController extends AuthController
{
    /**
     * The GameModRepository instance.
     *
     * @var \Gameap\Repositories\GameModRepository
     */
    public $repository;

    /**
     * GameModsController constructor.
     * @param GameModRepository $repository
     */
    public function __construct(GameModRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    public function getListForGame(string $gameCode)
    {
        return $this->repository->getIdNameListForGame($gameCode);
    }

    public function index()
    {
        $game_mods = GameMod::all();

        return response()->json($game_mods);
    }

    public function store(Request $request)
    {
        $game_mod = GameMod::create($request->all());

        return response()->json($game_mod, 201);
    }

    public function show(GameMod $game_mod)
    {
        return response()->json($game_mod);
    }

    public function update(Request $request, GameMod $game_mod)
    {
        $game_mod->update($request->all());

        return response()->json($game_mod, 200);
    }

    public function destroy(GameMod $game_mod)
    {
        $game_mod->delete();

        return response()->json(null, 204);
    }
}
