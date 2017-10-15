<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

class GameMod extends Model
{
    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_code', 'code');
    }
}
