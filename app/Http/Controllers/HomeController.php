<?php

namespace Gameap\Http\Controllers;

use Cache;
use Gameap\Http\Requests\SendBugRequest;
use Gameap\Services\GlobalApi;
use Gameap\Services\InfoService;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        return view('help');
    }

    /**
     * Report a bug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportBug()
    {
        $extensions = get_loaded_extensions();
        return view('report_bug', compact('extensions'));
    }

    /**
     * Send bug
     *
     * @param SendBugRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Gameap\Exceptions\Services\ResponseException
     */
    public function sendBug(SendBugRequest $request)
    {
        GlobalApi::sendBug(
            $request->input('summary'),
            $request->input('description')
        );

        return redirect()->route('report_bug')
            ->with('success', __('home.send_bug_success_msg'));
    }

    /**
     * Upgrade panel page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update()
    {
        $latestVersion = InfoService::latestRelease();
        return view('update', compact('latestVersion'));
    }
}
