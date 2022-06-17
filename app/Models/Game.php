<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package Gameap\Models
 *
 * @property string $code
 * @property string $start_code
 * @property string $name
 * @property string $engine
 * @property string $engine_version
 * @property integer $steam_app_id_linux
 * @property integer $steam_app_id_windows
 * @property string $steam_app_set_config
 * @property string $remote_repository_linux
 * @property string $remote_repository_windows
 * @property string $local_repository_linux
 * @property string $local_repository_windows
 */
class Game extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'start_code', 'name',
        'engine', 'engine_version',
        'steam_app_id_linux', 'steam_app_id_windows',
        'steam_app_set_config',
        'remote_repository_linux', 'remote_repository_windows',
        'local_repository_linux', 'local_repository_windows'
    ];

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
    {
        return $this->hasMany(Server::class, 'game_id');
    }

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mods()
    {
        return $this->hasMany(GameMod::class);
    }
}
