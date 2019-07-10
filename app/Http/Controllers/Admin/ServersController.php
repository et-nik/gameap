<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\ServerCreateRequest;
use Gameap\Http\Requests\Admin\ServerUpdateRequest;
use Gameap\Models\Game;
use Gameap\Models\Server;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\ServerRepository;

class ServersController extends AuthController
{
    /**
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    protected $repository;

    /**
     * Create a new ServersController instance.
     *
     * @param  \Gameap\Repositories\ServerRepository $repository
     */
    public function __construct(ServerRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.servers.list',[
            'servers' => $this->repository->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.servers.create', [
            'dedicatedServers' => DedicatedServer::all()->pluck('name', 'id'),
            'games' => Game::orderBy('name')->get()->pluck('name', 'code')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\ServerCreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServerCreateRequest $request)
    {
        $this->repository->store($request->all());

        return redirect()->route('admin.servers.index')
            ->with('success', __('servers.create_success_msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\View\View
     */
    public function edit(Server $server)
    {
        $dedicatedServers = DedicatedServer::all(['id', 'name'])->pluck('name', 'id');
        $games = Game::orderBy('name')->get()->pluck('name', 'code');
        return view('admin.servers.edit', compact('server', 'dedicatedServers', 'games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\ServerUpdateRequest  $request
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Server $server)
    {
        $server->delete();
        return redirect()->route('admin.servers.index')
            ->with('success', __('servers.delete_success_msg'));
    }
}
