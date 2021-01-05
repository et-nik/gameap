<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\SendBugRequest;
use Gameap\Services\GlobalApi;
use Gameap\Services\InfoService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /** @var InfoService */
    private $infoService;

    public function __construct(InfoService $infoService)
    {
        $this->middleware('auth');

        $this->infoService = $infoService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $infoService   = $this->infoService;
        $latestVersion = Cache::remember('latestVersion', 3600, static function () use ($infoService) {
            return $infoService->latestRelease();
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
        $latestVersion = $this->infoService->latestRelease();
        return view('update', compact('latestVersion'));
    }
}
