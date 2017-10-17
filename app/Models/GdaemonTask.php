<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class GdaemonTask
 * @package App\Models
 * @version September 19, 2017, 1:29 pm UTC
 *
 * @property integer run_aft_id
 * @property integer dedicated_server_id
 * @property integer server_id
 * @property string task
 * @property string data
 * @property string cmd
 * @property string output
 * @property string status
 */
class GdaemonTask extends Model
{

    public $table = 'gdaemon_tasks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const TASK_SERVER_START     = 'gsstart';
    const TASK_SERVER_STOP      = 'gsstop';
    const TASK_SERVER_RESTART   = 'gsrest';
    const TASK_SERVER_UPDATE    = 'gsinst';
    const TASK_SERVER_INSTALL   = 'gsinst';
    const TASK_SERVER_DELETE    = 'gsdel';
    const TASK_SERVER_MOVE      = 'gsmove';
    const TASK_CMD_EXEC         = 'cmdexec';
    
    const STATUS_WAITING        = 'waiting';
    const STATUS_WORKING        = 'working';
    const STATUS_ERROR          = 'error';
    const STATUS_SUCCESS        = 'success';

    public $fillable = [
        'run_aft_id',
        'dedicated_server_id',
        'server_id',
        'task',
        'data',
        'cmd',
        'output',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'run_aft_id' => 'integer',
        'dedicated_server_id' => 'integer',
        'server_id' => 'integer',
        'task' => 'string',
        'data' => 'string',
        'cmd' => 'string',
        'output' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
