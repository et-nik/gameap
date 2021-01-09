<?php

namespace Tests\Unit\Services\Modules;

use Config;
use Gameap\Exceptions\GameapException;
use Gameap\Exceptions\InvalidArgumentValueException;
use Gameap\Exceptions\Services\ResponseException;
use Gameap\Services\Modules\MarketplaceService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

/** @covers \Gameap\Services\Modules\MarketplaceService */
class MarketplaceServiceTest extends TestCase
{
    private static $jsonIndex = <<<JSON
        {
          "example1": {
              "tags": ["tag1", "tag2"],
              "name": "Example 1",
              "summary": {
                  "en": "summary"
              }
          },
          "example2": {
              "tags": ["tag1"],
              "name": "Example 2",
              "summary": {
                  "en": "summary"
              }
          }
        }
    JSON;

    private static $jsonModule = <<<JSON
        {
            "description": {
                "en": "Example module"
            },
            "versions": {
                "1.3.2": {
                    "mirrors": [
                        "https://example.com/download/example-module.tar.gz"
                    ]
                }
            }
        }
    JSON;


    public function testGetList(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $response = new Response(200, [], self::$jsonIndex);
        $httpClientMock->shouldReceive('request')->andReturn($response);
        $marketplaceService = new MarketplaceService($httpClientMock);

        $result = $marketplaceService->getList();

        Assert::assertIsArray($result);
        Assert::assertArrayHasKey('example1', $result);
        Assert::assertArrayHasKey('example2', $result);
        Assert::assertArrayHasKey('tags', $result['example1']);
        Assert::assertArrayHasKey('name', $result['example1']);
        Assert::assertArrayHasKey('name', $result['example2']);
        Assert::assertSame(['tag1', 'tag2'], $result['example1']['tags']);
        Assert::assertSame('Example 1', $result['example1']['name']);
        Assert::assertSame('Example 2', $result['example2']['name']);
    }

    public function testGetList_FailWhenResponseCodeIsNotOk(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $response = new Response(500);
        $httpClientMock->shouldReceive('request')->andReturn($response);
        $marketplaceService = new MarketplaceService($httpClientMock);
        $this->expectException(ResponseException::class);

        $marketplaceService->getList();
    }

    public function testGetModule(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $response = new Response(200, [], self::$jsonModule);
        $httpClientMock->shouldReceive('request')->andReturn($response);
        $marketplaceService = new MarketplaceService($httpClientMock);

        $result = $marketplaceService->getModule('https://example.com/repository', 'example1');

        Assert::assertIsArray($result);
        Assert::assertArrayHasKey('description', $result);
        Assert::assertArrayHasKey('en', $result['description']);
        Assert::assertSame('Example module', $result['description']['en']);
    }

    public function testDownloadModule(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $findResponse = new Response(200, [], self::$jsonIndex);
        $moduleResponse = new Response(200, [], self::$jsonModule);
        $fileResponse = new Response(200, [], 'file contents');
        $httpClientMock->shouldReceive('request')
            ->andReturn($findResponse, $moduleResponse, $fileResponse);
        $marketplaceService = new MarketplaceService($httpClientMock);

        $result = $marketplaceService->downloadModule('example1', '1.3.2');

        Assert::assertFileExists($result);
    }

    public function testDownloadModule_invalidVersion(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $findResponse = new Response(200, [], self::$jsonIndex);
        $moduleResponse = new Response(200, [], self::$jsonModule);
        $fileResponse = new Response(200, [], 'file contents');
        $httpClientMock->shouldReceive('request')
            ->andReturn($findResponse, $moduleResponse, $fileResponse);
        $marketplaceService = new MarketplaceService($httpClientMock);
        $this->expectException(InvalidArgumentValueException::class);
        $this->expectExceptionMessage('Invalid module version');

        $marketplaceService->downloadModule('example1', '99.99.99');
    }

    public function testDownloadModule_whenFailedToDownloadFromMirror(): void
    {
        $httpClientMock = Mockery::mock(Client::class);
        $findResponse = new Response(200, [], self::$jsonIndex);
        $moduleResponse = new Response(200, [], self::$jsonModule);
        $invalidMirrorfileResponse = new Response(500, []);
        $httpClientMock->shouldReceive('request')
            ->andReturn($findResponse, $moduleResponse, $invalidMirrorfileResponse);
        $marketplaceService = new MarketplaceService($httpClientMock);
        $this->expectException(GameapException::class);
        $this->expectExceptionMessage('Unable to download module');

        $result = $marketplaceService->downloadModule('example1', '1.3.2');

    }

    public function testFindModule(): void
    {
        Config::set(MarketplaceService::CONFIG_REPOSITORIES_NAME, ['http://example.com/r1', 'http://example.com/r2']);
        $httpClientMock = Mockery::mock(Client::class);
        $emptyResponse = new Response(200, [], '[]');
        $indexResponse = new Response(200, [], self::$jsonIndex);
        $moduleResponse = new Response(200, [], self::$jsonModule);
        $httpClientMock->shouldReceive('request')->andReturn($emptyResponse, $indexResponse, $moduleResponse);
        $marketplaceService = new MarketplaceService($httpClientMock);

        $result = $marketplaceService->findModule('example1');

        Assert::assertIsArray($result);
        Assert::assertArrayHasKey('description', $result);
        Assert::assertArrayHasKey('en', $result['description']);
        Assert::assertSame('Example module', $result['description']['en']);
    }

    public function testFindModule_moduleNotExists(): void
    {
        Config::set(MarketplaceService::CONFIG_REPOSITORIES_NAME, ['http://example.com/r2']);
        $httpClientMock = Mockery::mock(Client::class);
        $emptyResponse = new Response(200, [], '[]');
        $httpClientMock->shouldReceive('request')->andReturn($emptyResponse);
        $marketplaceService = new MarketplaceService($httpClientMock);

        $result = $marketplaceService->findModule('example1');

        Assert::assertNull($result);
    }
}
