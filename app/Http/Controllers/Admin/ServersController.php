<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\ServerRequest;
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
            'games' => Game::all()->pluck('name', 'code')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Gameap\Http\Requests\ServerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServerRequest $request)
    {
        $this->repository->store($request->all());

        return redirect()->route('admin.servers.index')
            ->with('success','Game server created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\View\View
     */
    public function show(Server $server)
    {
        return view('admin.servers.view', compact('server'));
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
        $games = Game::all()->pluck('name', 'code');
        return view('admin.servers.edit', compact('server', 'dedicatedServers', 'games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\ServerRequest  $request
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServerRequest $request, Server $server)
    {
        $server->update($request->all());

        return redirect()->route('admin.servers.index')
            ->with('success','Game server updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Server $server)
    {
        $server->delete();
        return redirect()->route('admin.servers.index')
            ->with('success','Game server deleted successfully');
    }
}
