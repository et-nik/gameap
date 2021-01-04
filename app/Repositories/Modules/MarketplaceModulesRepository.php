<?php

namespace Gameap\Repositories\Modules;

use Gameap\Models\Modules\MarketplaceModule;
use Gameap\Services\Modules\MarketplaceService;
use Illuminate\Support\Facades\Config;

class MarketplaceModulesRepository
{
    /** @var MarketplaceService */
    private $marketplaceService;

    public function __construct(MarketplaceService $marketplaceService)
    {
        $this->marketplaceService = $marketplaceService;
    }

    /** @return []Module */
    public function getAll(): iterable
    {
        $modules = [];
        foreach ($this->marketplaceService->getList() as $id => $module) {
            $modules[] = $this->denormalizeModule($id, $module);
        }

        return $modules;
    }

    public function find(string $moduleID): ?MarketplaceModule
    {
        $module = $this->marketplaceService->findModule($moduleID);

        if ($module === null) {
            return null;
        }

        return $this->denormalizeModule($moduleID, $module);
    }

    private function denormalizeModule(string $id, array $array): MarketplaceModule
    {
        $module = new MarketplaceModule();

        $locale         = Config::get('app.locale');
        $fallbackLocale = Config::get('app.fallback_locale');

        $module->id             = $id;
        $module->name           = $array['name'] ?? '';
        $module->summary        = $array['summary'][$locale]
            ?? $array['summary'][$fallbackLocale]
            ?? '';
        $module->description    = $array['description'][$locale]
            ?? $array['description'][$fallbackLocale]
            ?? '';
        $module->tags           = $array['tags'] ?? [];
        $module->latestVersion  = $array['latest_version'] ?? '';

        return $module;
    }
}
