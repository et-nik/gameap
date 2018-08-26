<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

class GameMod extends Model
{
    public $timestamps = false;

    /**
     * One to one relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_code', 'code');
    }

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
    {
        return $this->hasMany(Server::class);
    }
}
