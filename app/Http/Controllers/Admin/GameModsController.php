<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Game;
use Gameap\Repositories\GameModRepository;
use Gameap\Models\GameMod;
use Gameap\Http\Requests\Admin\GameModRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GameModsController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var GameModRepository
     */
    protected $repository;

    /**
     * Create a new GameController instance.
     *
     * @param GameModRepository $repository
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
     * @return Factory|View
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
     * @param  GameModRequest  $request
     * @return RedirectResponse
     */
    public function store(GameModRequest $request)
    {
        GameMod::create($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', __('games.mod_create_success_msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GameMod  $gameMod
     * @return View
     */
    public function edit(GameMod $gameMod)
    {
        return view('admin.game_mods.edit', compact('gameMod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GameModRequest  $request
     * @param GameMod $gameMod
     * @return RedirectResponse
     */
    public function update(GameModRequest $request, GameMod $gameMod)
    {
        $gameMod->update($request->all());

        return redirect()->route('admin.games.edit', ['game' => $gameMod->game_code])
            ->with('success', __('games.mod_update_success_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GameMod $gameMod
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(GameMod $gameMod)
    {
        $gameMod->delete();
        return redirect()->route('admin.games.index')
            ->with('success', __('games.mod_delete_success_msg'));
    }
}