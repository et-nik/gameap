<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServerSetting
 * @package Gameap\Models
 *
 * @property integer $id
 * @property integer $server_id
 * @property integer $name
 * @property mixed   $value
 *
 * @property Server $server
 */
class ServerSetting extends Model
{
    public $table = 'servers_settings';
    public $timestamps = false;
    
    public $fillable = [
        'server_id',
        'name',
        'value',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
