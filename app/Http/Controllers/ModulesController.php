<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\Modules\InstallModuleRequest;
use Gameap\Repositories\Modules\LaravelModulesRepository;
use Gameap\Repositories\Modules\MarketplaceModulesRepository;
use Gameap\Services\Modules\Installer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class ModulesController extends AuthController
{
    /** @var MarketplaceModulesRepository */
    private $marketplaceModulesRepository;

    /** @var LaravelModulesRepository */
    private $laravelModulesRepository;

    /** @var Installer */
    private $modulesInstaller;

    public function __construct(
        MarketplaceModulesRepository $modulesRepository,
        LaravelModulesRepository $laravelModulesRepository,
        Installer $modulesInstaller
    ) {
        parent::__construct();

        $this->marketplaceModulesRepository = $modulesRepository;
        $this->laravelModulesRepository     = $laravelModulesRepository;
        $this->modulesInstaller             = $modulesInstaller;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $modules = $this->laravelModulesRepository->getCached();

        return view('modules/installed', compact('modules'));
    }

    public function marketplace()
    {
        $installedModules = $this->laravelModulesRepository->getModulesVersions();
        $modules          = $this->marketplaceModulesRepository->getAll();

        return view('modules/marketplace', compact('modules', 'installedModules'));
    }

    /**
     * @throws \Gameap\Exceptions\GameapException
     * @throws \Gameap\Exceptions\InvalidArgumentValueException
     * @throws \splitbrain\PHPArchive\ArchiveCorruptedException
     * @throws \splitbrain\PHPArchive\ArchiveIOException
     * @throws \splitbrain\PHPArchive\ArchiveIllegalCompressionException
     */
    public function install(InstallModuleRequest $request): RedirectResponse
    {
        $moduleID = $request->input('module');
        $version  = $request->input('version');

        $this->modulesInstaller->install($moduleID, $version);

        Artisan::call('module:enable ' . $moduleID);
        Artisan::call('module:migrate ' . $moduleID);

        return redirect(route('modules.marketplace'))->with('success', __('modules.install_success_msg'));
    }

    public function destroy(string $moduleId): RedirectResponse
    {
        $this->laravelModulesRepository->delete($moduleId);

        return redirect(route('modules'))->with('success', __('modules.remove_success_msg'));
    }

    public function migrate(): RedirectResponse
    {
        Artisan::call('migrate');
        Artisan::call('module:migrate');

        return redirect(route('modules'))->with('success', __('modules.migrate_success_msg'));
    }
}
