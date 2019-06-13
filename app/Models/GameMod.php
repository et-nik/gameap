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
 * @property array $vars
 * @property string $remote_repository
 * @property string $local_repository
 * @property string $default_start_cmd_linux
 * @property string $default_start_cmd_windows
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
        'default_start_cmd_linux', 'default_start_cmd_windows',
        'kick_cmd', 'ban_cmd', 'chname_cmd', 'srestart_cmd', 'chmap_cmd', 'sendmsg_cmd', 'passwd_cmd'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = [
        'name'      => 'required|string|max:255',
        'game_code' => 'sometimes|string|max:255|exists:games,code',

        'default_start_cmd_linux' => 'string|max:255',
        'default_start_cmd_windows' => 'string|max:255',

        'vars.*.var' => 'max:16',
        'vars.*.default' => 'max:64',
        'vars.*.info' => 'max:128',

        'fast_rcon.*.info' => 'max:32',
        'fast_rcon.*.command' => 'max:128',
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

        return parent::castAttribute($key, $value);
    }
}
