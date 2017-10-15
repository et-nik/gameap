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
    }

    /**
     * Display a listing of the games.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
        Game::create($request->all());

        return redirect()->route('admin.games.index')
            ->with('success','Game created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return view('admin.games.view', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(GameRequest $request, Game $game)
    {
        $game->update($request->all());

        return redirect()->route('admin.games.index')
            ->with('success','Games updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')
            ->with('success','Game deleted successfully');
    }
}
