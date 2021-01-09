<?php

namespace Tests\Unit\Controllers\Admin;

use Gameap\Http\Controllers\Admin\GdaemonTasksController;
use Gameap\Http\Controllers\ModulesController;
use Gameap\Models\Modules\LaravelModule;
use Gameap\Models\Modules\MarketplaceModule;
use Gameap\Repositories\Modules\LaravelModulesRepository;
use Gameap\Repositories\Modules\MarketplaceModulesRepository;
use Gameap\Services\Modules\Installer;
use Illuminate\Container\Container;
use Illuminate\View\View;
use Mockery;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ModulesControllerTest extends TestCase
{
    /** @var ModulesController */
    protected $controller;

    /** @var MarketplaceModulesRepository|Mockery\LegacyMockInterface|Mockery\MockInterface */
    protected $marketplaceModulesRepositoryMock;

    /** @var LaravelModulesRepository|Mockery\LegacyMockInterface|Mockery\MockInterface */
    protected $laravelModulesRepositoryMock;

    /** @var Installer|Mockery\LegacyMockInterface|Mockery\MockInterface */
    protected $installerMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->marketplaceModulesRepositoryMock = Mockery::mock(MarketplaceModulesRepository::class);
        $this->laravelModulesRepositoryMock = Mockery::mock(LaravelModulesRepository::class);
        $this->installerMock = Mockery::mock(Installer::class);
        $this->controller = new ModulesController(
            $this->marketplaceModulesRepositoryMock,
            $this->laravelModulesRepositoryMock,
            $this->installerMock,
        );
    }

    public function testIndex(): void
    {
        $module = new LaravelModule();
        $this->laravelModulesRepositoryMock
            ->shouldReceive('getCached')
            ->andReturn([$module]);

        $result = $this->controller->index();

        Assert::assertInstanceOf(View::class, $result);
        /** @var View $result */
        Assert::assertSame('modules.installed', $result->getName());
        Assert::assertSame([$module], $result->getData()['modules']);
    }

    public function testMarketplace(): void
    {
        $module = new MarketplaceModule();
        $this->laravelModulesRepositoryMock
            ->shouldReceive('getModulesVersions')
            ->andReturn(['module' => '1.0']);
        $this->marketplaceModulesRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn([$module]);

        $result = $this->controller->marketplace();

        Assert::assertInstanceOf(View::class, $result);
        /** @var View $result */
        Assert::assertSame('modules.marketplace', $result->getName());
        Assert::assertSame([$module], $result->getData()['modules']);
        Assert::assertSame(['module' => '1.0'], $result->getData()['installedModules']);
    }
}
