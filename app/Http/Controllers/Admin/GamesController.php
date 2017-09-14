<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\Controller;
use Gameap\Models\Game;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('admin.games.list', [
            'games' => $games,
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

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:games|alpha_num|max:16',
            'start_code' => 'required|max:16',
            'name' => 'required|min:2',
            'engine' => 'required|min:2',
            'engine_version' => 'required',
        ]);

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        return view('admin.games.edit', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gameap\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        request()->validate([
            'code' => 'unique:games|alpha_num|max:16',
            'start_code' => 'required|max:16',
            'name' => 'required|min:2',
            'engine' => 'required|min:2',
            'engine_version' => 'required',
        ]);

        $game->update($request->all());

        return redirect()->route('admin.games.index')
            ->with('success','Games updated successfully');
    }
}
