<?php

namespace Tests\Unit\Repositories;

use Gameap\Models\Modules\MarketplaceModule;
use Gameap\Repositories\Modules\MarketplaceModulesRepository;
use Gameap\Services\Modules\MarketplaceService;
use Mockery;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class MarketplaceModulesRepositoryTest extends TestCase
{
    private static $modulesList = [
        'example' => [
            'name'           => 'Example',
            'summary'        => ['en' => 'Summary'],
            'description'    => ['en' => 'Description'],
            'latest_version' => '1.0',
        ],
    ];

    private static $module = [
        'name'        => 'Example',
        'summary'     => ['en' => 'Summary'],
        'description' => ['en' => 'Description'],
        'version'     => '1.0',
    ];


    public function testGetAll(): void
    {
        $marketPlaceServiceMock = Mockery::mock(MarketplaceService::class);
        $marketPlaceServiceMock->shouldReceive('getList')->andReturn(self::$modulesList);
        $modulesRepository = new MarketplaceModulesRepository($marketPlaceServiceMock);

        $result = $modulesRepository->getAll();

        Assert::assertIsArray($result);
        Assert::assertCount(1, $result);
        Assert::assertInstanceOf(MarketplaceModule::class, $result[0]);
        /** @var MarketplaceModule $module */
        $module = $result[0];
        Assert::assertEquals('Example', $module->name);
        Assert::assertEquals('Summary', $module->summary);
        Assert::assertEquals('Description', $module->description);
        Assert::assertEquals('1.0', $module->latestVersion);
    }

    public function testFind(): void
    {
        $marketPlaceServiceMock = Mockery::mock(MarketplaceService::class);
        $marketPlaceServiceMock->shouldReceive('findModule')->andReturn(self::$module);
        $modulesRepository = new MarketplaceModulesRepository($marketPlaceServiceMock);

        $result = $modulesRepository->find('example');

        Assert::assertInstanceOf(MarketplaceModule::class, $result);
        /** @var MarketplaceModule $result */
        Assert::assertEquals('Example', $result->name);
        Assert::assertEquals('Summary', $result->summary);
        Assert::assertEquals('Description', $result->description);
    }

    public function testFind_NullWhenModuleNotExists(): void
    {
        $marketPlaceServiceMock = Mockery::mock(MarketplaceService::class);
        $marketPlaceServiceMock->shouldReceive('findModule')->andReturn(null);
        $modulesRepository = new MarketplaceModulesRepository($marketPlaceServiceMock);

        $result = $modulesRepository->find('example');

        Assert::assertNull($result);
    }
}
