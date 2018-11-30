<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Validable;
use Sofa\Eloquence\Contracts\Validable as ValidableContract;

/**
 * Class GameMod
 * @package Gameap\Models
 *
 * @property integer $id
 * @property string $game_code
 * @property string $name
 * @property string $fast_rcon
 * @property string $vars
 * @property string $remote_repository
 * @property string $local_repository
 * @property string $kick_cmd
 * @property string $ban_cmd
 * @property string $chname_cmd
 * @property string $srestart_cmd
 * @property string $chmap_cmd
 * @property string $sendmsg_cmd
 * @property string $passwd_cmd
 */
class GameMod extends Model implements ValidableContract
{
    use Validable;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'game_code',
        'fast_rcon', 'vars',
        'remote_repository', 'local_repository',
        'kick_cmd', 'ban_cmd', 'chname_cmd', 'srestart_cmd', 'chmap_cmd', 'sendmsg_cmd', 'passwd_cmd'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = [
        'name'      => 'required|string|max:255|unique:game_mods',
        'game_code' => 'sometimes|string|max:255|exists:games,code',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'vars' => 'array',
        'fast_rcon' => 'array',
    ];

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
