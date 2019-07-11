<?php

namespace Gameap\Http\Controllers\Admin;

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
}