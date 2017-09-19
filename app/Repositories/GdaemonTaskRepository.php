<?php

namespace App\Repositories;

use App\Models\GdaemonTask;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GdaemonTaskRepository
 * @package App\Repositories
 * @version September 19, 2017, 1:29 pm UTC
 *
 * @method GdaemonTask findWithoutFail($id, $columns = ['*'])
 * @method GdaemonTask find($id, $columns = ['*'])
 * @method GdaemonTask first($columns = ['*'])
*/
class GdaemonTaskRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return GdaemonTask::class;
    }
}
