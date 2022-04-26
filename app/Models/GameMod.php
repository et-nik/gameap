<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GameMod
 * @package Gameap\Models
 *
 * @property integer $id
 * @property string $game_code
 * @property string $name
 * @property array $fast_rcon
 * @property array $vars
 * @property string $remote_repository
 * @property string $local_repository
 * @property string $start_cmd_nix
 * @property string $start_cmd_win
 * @property string $kick_cmd
 * @property string $ban_cmd
 * @property string $chname_cmd
 * @property string $srestart_cmd
 * @property string $chmap_cmd
 * @property string $sendmsg_cmd
 * @property string $passwd_cmd
 */
class GameMod extends Model
{
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
        'remote_repository_nix', 'remote_repository_win',
        'local_repository_nix', 'local_repository_win',
        'start_cmd_nix', 'start_cmd_win',
        'kick_cmd', 'ban_cmd', 'chname_cmd', 'srestart_cmd', 'chmap_cmd', 'sendmsg_cmd', 'passwd_cmd',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = [
        'name'      => 'required|string|max:255',
        'game_code' => 'sometimes|string|max:255|exists:games,code',

        'start_cmd_nix'   => 'nullable|string|max:1000',
        'start_cmd_win' => 'nullable|string|max:1000',

        'vars.*.var'       => 'max:16',
        'vars.*.default'   => 'max:64',
        'vars.*.info'      => 'max:128',
        'vars.*.admin_var' => 'max:128',

        'fast_rcon.*.info'    => 'max:32',
        'fast_rcon.*.command' => 'max:128',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'vars'      => 'array',
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

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && (is_null($value) || empty($value))) {
            return [];
        }

        $castValue = parent::castAttribute($key, $value);

        if ($this->getCastType($key) == 'array' && !is_array($castValue)) {
            return [];
        }

        return $castValue;
    }
}
