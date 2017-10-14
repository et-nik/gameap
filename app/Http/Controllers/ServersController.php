<?php

namespace Gameap\Http\Controllers;

use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;

class ServersController extends Controller
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
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('servers.list',[
            'servers' => $this->repository->getAll()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        return view('servers.view', compact('server'));
    }
}