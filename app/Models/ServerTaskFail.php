<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ServerTaskFail Model
 * @package Gameap\Models
 *
 * @property integer $id
 * @property integer $server_task_id
 * @property string $output
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ServerTask $serverTask
 */
class ServerTaskFail extends Model
{
    public $table = 'servers_tasks_fails';

    protected $casts = [
        'id'                => 'integer',
        'server_task_id'    => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serverTask()
    {
        return $this->belongsTo(ServerTask::class);
    }
}