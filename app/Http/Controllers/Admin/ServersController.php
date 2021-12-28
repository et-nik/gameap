<?php

namespace Gameap\Http\Controllers\Admin;

use Exception;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\CreateServerRequest;
use Gameap\Http\Requests\Admin\ServerDestroyRequest;
use Gameap\Http\Requests\Admin\ServerUpdateRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\Server;
use Gameap\Repositories\GameModRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\UseCases\Commands\CreateGameServerCommand;
use Gameap\UseCases\CreateGameServer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\Serializer\SerializerInterface;

class ServersController extends AuthController
{
    /** @var GdaemonTaskRepository  */
    public $gdaemonTaskRepository;

    /** @var ServerRepository */
    protected $repository;

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        ServerRepository $repository,
        GdaemonTaskRepository $gdaemonTaskRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct();

        $this->repository            = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->serializer            = $serializer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('admin.servers.list', [
            'servers' => $this->repository->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.servers.create', [
            'dedicatedServers' => DedicatedServer::all()->pluck('name', 'id'),
            'games'            => Game::orderBy('name')->get()->pluck('name', 'code'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateServerRequest $request
     * @return RedirectResponse
     * @throws RecordExistExceptions
     */
    public function store(CreateServerRequest $request, CreateGameServer $createGameServer)
    {
        $command = $this->serializer->denormalize(
            $request->all(),
            CreateGameServerCommand::class,
        );

        $createGameServer($command);

        return redirect()->route('admin.servers.index')
            ->with('success', __('servers.create_success_msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Server $server
     * @return View
     */
    public function edit(Server $server)
    {
        $dedicatedServers = DedicatedServer::all(['id', 'name'])->pluck('name', 'id');
        $games            = Game::orderBy('name')->get()->pluck('name', 'code');
        return view('admin.servers.edit', compact('server', 'dedicatedServers', 'games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServerUpdateRequest $request
     * @param Server $server
     * @return RedirectResponse
     */
    public function update(ServerUpdateRequest $request, Server $server)
    {
        $this->repository->update($server, $request->all());
        
        return redirect()->route('admin.servers.index')
            ->with('success', __('servers.update_success_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Server $server
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(ServerDestroyRequest $request, Server $server)
    {
        if ($request->input('delete_files')) {
            try {
                $this->gdaemonTaskRepository->addServerDelete($server);
            } catch (RecordExistExceptions $e) {
                // Nothing
            }

            $server->delete();
        } else {
            $server->forceDelete();
        }

        return redirect()->route('admin.servers.index')
            ->with('success', __('servers.delete_success_msg'));
    }
}
