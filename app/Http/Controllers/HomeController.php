<?php

namespace Gameap\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Gameap\Services\InfoService;
use Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestVersion = Cache::remember('latestVersion', 3600, function () {
            return InfoService::latestRelease();
        });

        $modules = app()['modules']->getCached();
        
        return view('home', compact('latestVersion', 'modules'));
    }

    /**
     * Show help information (GameAP resources etc)
     * @return \Illuminate\Http\Response
     */
    public function help()
    {
        return view('help');
    }

    /**
     * Report a bug
     */
    public function reportBug()
    {
        $extensions = get_loaded_extensions();
        return view('report_bug', compact('extensions'));
    }

    /**
     * Upgrade panel page
     */
    public function update()
    {
        $latestVersion = InfoService::latestRelease();
        return view('update', compact('latestVersion'));
    }
}
