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
