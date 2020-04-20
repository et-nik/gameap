<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use \Gameap\Http\Controllers\AuthController;
use \Gameap\Repositories\GdaemonTaskRepository;
use \Gameap\Models\GdaemonTask;

class GdaemonTasksController extends AuthController 
{
    /**
     * The GdaemonTasksRepository instance.
     *
     * @var \Gameap\Repositories\GdaemonTaskRepository
     */
    protected $repository;

    /**
     * Create a new GdaemonTasksController instance.
     *
     * @param  \Gameap\Repositories\GdaemonTaskRepository $repository
     */
    public function __construct(GdaemonTaskRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the games.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.gdaemon_tasks.list',[
            'gdaemonTasks' => $this->repository->getAll()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\GdaemonTask  $gdaemonTask
     * @return \Illuminate\View\View
     */
    public function show(GdaemonTask $gdaemonTask)
    {
        return view('admin.gdaemon_tasks.view', compact('gdaemonTask'));
    }

    /**
     * @param GdaemonTask $gdaemonTask
     */
    public function cancel(GdaemonTask $gdaemonTask)
    {
        try {
            $this->repository->cancel($gdaemonTask);
        } catch (GdaemonTaskRepositoryException $exception) {
            return redirect()->route('admin.gdaemon_tasks.show', $gdaemonTask->getKey())
                ->with('error', __('gdaemon_tasks.canceled_fail_msg', [
                    'error' => $exception->getMessage(),
                ]));
        }

        return redirect()->route('admin.gdaemon_tasks.show', $gdaemonTask->getKey())
            ->with('success', __('gdaemon_tasks.canceled_success_msg'));
    }
}