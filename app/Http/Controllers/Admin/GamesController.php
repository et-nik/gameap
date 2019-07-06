<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Game;
use Gameap\Repositories\GameRepository;
use Gameap\Http\Requests\GameRequest;

class GamesController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameRepository
     */
    protected $repository;

    /**
     * Create a new GameController instance.
     *
     * @param  \Gameap\Repositories\GameRepository $repository
     */
    public function __construct(GameRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * Display a listing of the games.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.games.list',[
            'games' => $this->repository->getAll()
        ]);
    }

    /**
     * Display new create game page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.games.create');
    }

    /**
     * Store a newly created game in storage.
     *
     * @param  \Gameap\Http\Requests\GameRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GameRequest $request)
    {
        Game::create($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', __('games.create_success_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\View\View
     */
    public function show(Game $game)
    {
        return view('admin.games.view', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\View\View
     */
    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\GameRequest  $request
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GameRequest $request, Game $game)
    {
        $game->update($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', __('games.update_success_msg'));
    }

    /**
     * Upgrade games and game mods from GameAP Repository
     *
     */
    public function upgrade()
    {
        $result = $this->repository->upgradeFromRepo();

        if ($result) {
            return redirect()->route('admin.games.index')
                ->with('success', __('games.upgrade_success_msg'));
        } else {
            return redirect()->route('admin.games.index')
                ->with('error', __('games.upgrade_fail_msg'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')
            ->with('success', __('games.delete_success_msg'));
    }
}
