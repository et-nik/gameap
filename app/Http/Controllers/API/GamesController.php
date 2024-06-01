<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Game;
use Gameap\Repositories\GameRepository;
use Illuminate\Http\Request;

class GamesController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameRepository
     */
    public $repository;

    /**
     * GamesController constructor.
     * @param GameRepository $repository
     */
    public function __construct(GameRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    public function index()
    {
        $games = Game::all();

        return response()->json($games);
    }

    public function store(Request $request)
    {
        $game = Game::create($request->all());

        return response()->json($game, 201);
    }

    public function show(Game $game)
    {
        return response()->json($game);
    }

    public function update(Request $request, Game $game)
    {
        $game->update($request->all());

        return response()->json($game, 200);
    }

    public function upgrade()
    {
        $result = $this->repository->upgradeFromRepo();

        if ($result) {
            return response()->json(['message' => 'Games and Game Mods upgraded'], 200);
        } else {
            return response()->json(['message' => 'Error while upgrading Games and Game Mods'], 500);
        }
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(null, 204);
    }
}
