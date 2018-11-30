<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Game;
use Gameap\Repositories\GameModRepository;
use Gameap\Models\GameMod;
use Gameap\Http\Requests\GameModRequest;

class GameModsController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameModRepository
     */
    protected $repository;

    /**
     * Create a new GameController instance.
     *
     * @param  \Gameap\Repositories\GameModRepository $repository
     */
    public function __construct(GameModRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * Display new create game mod page
     *
     * @param string|null
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($game = null)
    {
        return view('admin.game_mods.create', [
            'game' => $game,
            'gameList' => Game::all()->pluck('name', 'code'),
        ]);
    }

    /**
     * Store a newly created game mod in storage.
     *
     * @param  \Gameap\Http\Requests\GameModRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameModRequest $request)
    {
        GameMod::create($request->all());

        return redirect()->route('admin.games.index')
            ->with('success','Game mod created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\GameMod  $gameMod
     * @return \Illuminate\Http\Response
     */
    public function edit(GameMod $gameMod)
    {
        return view('admin.game_mods.edit', compact('gameMod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\GameModRequest  $request
     * @param  \Gameap\Models\GameMod  $gameMod
     * @return \Illuminate\Http\Response
     */
    public function update(GameModRequest $request, GameMod $gameMod)
    {
        $gameMod->update($request->all());

        return redirect()->route('admin.games.edit', ['game' => $gameMod->game_code])
            ->with('success','Game Mod updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\GameMod  $gameMod
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameMod $gameMod)
    {
        $gameMod->delete();
        return redirect()->route('admin.games.index')
            ->with('success','Game Mod deleted successfully');
    }
}