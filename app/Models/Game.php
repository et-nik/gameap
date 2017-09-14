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
 * @property integer $steam_app_id
 * @property string $steam_app_set_config
 * @property string $remote_repository
 * @property string $local_repository
 */
class Game extends Model
{
    public $timestamps = false;

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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public  $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'start_code', 'name', 
        'engine', 'engine_version',
    ];

//    protected $guarded = ['code'];
}
