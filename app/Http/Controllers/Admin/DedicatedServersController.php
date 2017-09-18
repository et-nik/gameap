<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\Controller;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\DedicatedServersRepository;
use Gameap\Http\Requests\DedicatedServerRequest;

class DedicatedServersController extends Controller
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\DedicatedServersRepository
     */
    protected $repository;

    /**
     * Create a new DedicatedServersController instance.
     *
     * @param  \Gameap\Repositories\DedicatedServersRepository $repository
     */
    public function __construct(DedicatedServersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dedicatedServers = $this->repository->getAll();
        return view('admin.dedicated_servers.list',[
            'dedicatedServers' => $this->repository->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dedicated_servers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Gameap\Http\Requests\DedicatedServerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DedicatedServerRequest $request)
    {
        DedicatedServer::create($request->all());

        return redirect()->route('admin.dedicated_servers.index')
            ->with('success','Dedicated server created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\Response
     */
    public function show(DedicatedServer $dedicatedServer)
    {
        return view('admin.dedicated_servers.view', compact('dedicatedServer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\Response
     */
    public function edit(DedicatedServer $dedicatedServer)
    {
        return view('admin.dedicated_servers.edit', compact('dedicatedServer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\DedicatedServerRequest  $request
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\Response
     */
    public function update(DedicatedServerRequest $request, DedicatedServer $dedicatedServer)
    {
        $dedicatedServer->update($request->all());

        return redirect()->route('admin.dedicated_servers.index')
            ->with('success','Dedicated server updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DedicatedServer $dedicatedServer)
    {
        $dedicatedServer->delete();
        return redirect()->route('admin.dedicated_servers.index')
            ->with('success','Dedicated server deleted successfully');
    }
}
