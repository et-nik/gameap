<?php

namespace Gameap\Http\Controllers;

use Illuminate\Http\Request;
use Gameap\Models\Game;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('games.list', [
            'games' => $games,
        ]);
    }
}
