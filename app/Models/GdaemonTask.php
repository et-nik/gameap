<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GdaemonTask
 * @package App\Models
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
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TASK_SERVER_START   = 'gsstart';
    public const TASK_SERVER_STOP    = 'gsstop';
    public const TASK_SERVER_RESTART = 'gsrest';
    public const TASK_SERVER_UPDATE  = 'gsinst';
    public const TASK_SERVER_INSTALL = 'gsinst';
    public const TASK_SERVER_DELETE  = 'gsdel';
    public const TASK_SERVER_MOVE    = 'gsmove';
    public const TASK_CMD_EXEC       = 'cmdexec';
    
    public const STATUS_WAITING  = 'waiting';
    public const STATUS_WORKING  = 'working';
    public const STATUS_ERROR    = 'error';
    public const STATUS_SUCCESS  = 'success';
    public const STATUS_CANCELED = 'canceled';

    public const NUM_STATUSES = [
        self::STATUS_WAITING  => 1,
        self::STATUS_WORKING  => 2,
        self::STATUS_ERROR    => 3,
        self::STATUS_SUCCESS  => 4,
        self::STATUS_CANCELED => 5,
    ];
    public $table = 'gdaemon_tasks';


    public $hidden = [
        'output',
    ];

    public $fillable = [
        'run_aft_id',
        'dedicated_server_id',
        'server_id',
        'task',
        'data',
        'cmd',
        'output',
        'status',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                  => 'integer',
        'run_aft_id'          => 'integer',
        'dedicated_server_id' => 'integer',
        'server_id'           => 'integer',
        'task'                => 'string',
        'data'                => 'string',
        'cmd'                 => 'string',
        'output'              => 'string',
        'status'              => 'string',
    ];

    public function getStatusNumAttribute()
    {
        return self::NUM_STATUSES[$this->status];
    }
}
