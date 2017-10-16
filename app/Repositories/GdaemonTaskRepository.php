<?php

namespace Gameap\Repositories;

use Gameap\Models\GdaemonTask;

/**
 * Class GdaemonTaskRepository
*/
class GdaemonTaskRepository
{
    public function getAll($perPage = 20)
    {
        $gdaemonTasks = GdaemonTask::orderBy('id')->paginate($perPage);
        return $gdaemonTasks;
    }
}
