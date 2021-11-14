<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ServerTask model
 * @package Gameap\Models
 *
 * @property integer $id
 * @property string $command
 * @property integer $server_id
 * @property integer $repeat
 * @property integer $repeat_period
 * @property integer $counter
 * @property string $execute_date
 * @property string $payload
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Server $server
 * @property ServerTaskFail $fails
 */
class ServerTask extends Model
{
    public $table = 'servers_tasks';

    protected $casts = [
        'id'            => 'integer',
        'server_id'     => 'integer',
        'repeat'        => 'integer',
        'repeat_period' => 'integer',
        'counter'       => 'integer',
    ];

    protected $fillable = [
        'command',
        'server_id',
        'repeat',
        'repeat_period',
        'execute_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fails()
    {
        return $this->hasMany(ServerTaskFail::class);
    }
}
