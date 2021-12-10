<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\SendBugRequest;
use Gameap\Repositories\Modules\LaravelModulesRepository;
use Gameap\Services\GlobalApi;
use Gameap\Services\InfoService;
use Gameap\Services\ProblemFinder;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    const LATEST_VERSION_CACHE_TTL_IN_SECONDS = 3600;

    /** @var InfoService */
    private $infoService;

    /** @var LaravelModulesRepository */
    private $laravelModulesRepository;

    /** @var ProblemFinder */
    private $problemFinder;

    public function __construct(
        InfoService $infoService,
        LaravelModulesRepository $laravelModulesRepository,
        ProblemFinder $problemFinder
    ) {
        $this->middleware('auth');

        $this->infoService              = $infoService;
        $this->laravelModulesRepository = $laravelModulesRepository;
        $this->problemFinder            = $problemFinder;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $infoService   = $this->infoService;
        $latestVersion = Cache::remember(
            'latestVersion',
            self::LATEST_VERSION_CACHE_TTL_IN_SECONDS,
            static function () use ($infoService) {
                return $infoService->latestRelease();
            }
        );
        $modules = $this->laravelModulesRepository->getCachedEnabled();
        $problems = $this->problemFinder->find();
        
        return view('home', [
            'latestVersion' => $latestVersion,
            'modules'       => $modules,
            'problems'      => $problems,
        ]);
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
