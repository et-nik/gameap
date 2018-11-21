<?php

namespace App\Http\Controllers;

use Gameap\Http\Requests\CreateGdaemonTaskRequest;
use Gameap\Http\Requests\UpdateGdaemonTaskRequest;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GdaemonTaskController extends Controller
{
    /** @var  GdaemonTaskRepository */
    private $gdaemonTaskRepository;

    public function __construct(GdaemonTaskRepository $gdaemonTaskRepo)
    {
        $this->gdaemonTaskRepository = $gdaemonTaskRepo;
    }

    /**
     * Display a listing of the GdaemonTask.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gdaemonTaskRepository->pushCriteria(new RequestCriteria($request));
        $gdaemonTasks = $this->gdaemonTaskRepository->all();

        return view('gdaemon_tasks.index')
            ->with('gdaemonTasks', $gdaemonTasks);
    }

    /**
     * Show the form for creating a new GdaemonTask.
     *
     * @return Response
     */
    public function create()
    {
        return view('gdaemon_tasks.create');
    }

    /**
     * Store a newly created GdaemonTask in storage.
     *
     * @param CreateGdaemonTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateGdaemonTaskRequest $request)
    {
        $input = $request->all();

        $gdaemonTask = $this->gdaemonTaskRepository->create($input);

        Flash::success('Gdaemon Task saved successfully.');

        return redirect(route('gdaemonTasks.index'));
    }

    /**
     * Display the specified GdaemonTask.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gdaemonTask = $this->gdaemonTaskRepository->findWithoutFail($id);

        if (empty($gdaemonTask)) {
            Flash::error('Gdaemon Task not found');

            return redirect(route('gdaemonTasks.index'));
        }

        return view('gdaemon_tasks.show')->with('gdaemonTask', $gdaemonTask);
    }

    /**
     * Show the form for editing the specified GdaemonTask.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gdaemonTask = $this->gdaemonTaskRepository->findWithoutFail($id);

        if (empty($gdaemonTask)) {
            Flash::error('Gdaemon Task not found');

            return redirect(route('gdaemonTasks.index'));
        }

        return view('gdaemon_tasks.edit')->with('gdaemonTask', $gdaemonTask);
    }

    /**
     * Update the specified GdaemonTask in storage.
     *
     * @param  int              $id
     * @param UpdateGdaemonTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGdaemonTaskRequest $request)
    {
        $gdaemonTask = $this->gdaemonTaskRepository->findWithoutFail($id);

        if (empty($gdaemonTask)) {
            Flash::error('Gdaemon Task not found');

            return redirect(route('gdaemonTasks.index'));
        }

        $gdaemonTask = $this->gdaemonTaskRepository->update($request->all(), $id);

        Flash::success('Gdaemon Task updated successfully.');

        return redirect(route('gdaemonTasks.index'));
    }

    /**
     * Remove the specified GdaemonTask from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gdaemonTask = $this->gdaemonTaskRepository->findWithoutFail($id);

        if (empty($gdaemonTask)) {
            Flash::error('Gdaemon Task not found');

            return redirect(route('gdaemonTasks.index'));
        }

        $this->gdaemonTaskRepository->delete($id);

        Flash::success('Gdaemon Task deleted successfully.');

        return redirect(route('gdaemonTasks.index'));
    }
}
