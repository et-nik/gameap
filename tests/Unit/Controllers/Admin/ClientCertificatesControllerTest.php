<?php

namespace Tests\Unit\Controllers\Admin;

use Gameap\Exceptions\GameapException;
use Gameap\Http\Controllers\Admin\ClientCertificatesController;
use Gameap\Http\Requests\ClientCertificatesRequest;
use Gameap\Models\ClientCertificate;
use Gameap\Repositories\ClientCertificateRepository;
use Illuminate\Container\Container;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Mockery;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\Admin\ClientCertificatesController
 */
class ClientCertificatesControllerTest extends TestCase
{
    /**
     * @var ClientCertificatesController
     */
    protected $controller;

    /**
     * @var ClientCertificateRepository|\Mockery\MockInterface
     */
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(ClientCertificateRepository::class);
        $container = Container::getInstance();
        $container->instance(ClientCertificateRepository::class, $this->repositoryMock);
        $this->controller = $container->make(ClientCertificatesController::class);
    }

    public function testIndex()
    {
        $this->repositoryMock->shouldReceive('getAll')->andReturn([
            Mockery::mock(ClientCertificate::class)
        ]);

        $response = $this->controller->index();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testCreate()
    {
        $response = $this->controller->create();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testShow()
    {
        $this->repositoryMock->shouldReceive('certificateInfo')->andReturn([
            'expires' => Carbon::createFromTimestamp(time())->toDateTimeString(),

            'signature_type' => 'SN',

            'country' => 'TST',
            'state' => 'TST',
            'locality' => 'TST',
            'organization' => 'TST',
            'organizational_unit' => 'TST',
            'common_name' => 'GameAP Tests',
            'email' => 'tests@gameap.ru',

            'issuer_country' => 'TST',
            'issuer_state' => 'TST',
            'issuer_locality' => 'TST',
            'issuer_organization' => 'TST',
            'issuer_organizational_unit' => 'TST',
            'issuer_common_name' => 'TST',
            'issuer_email' => 'TST',
        ]);

        $response = $this->controller->show(Mockery::mock(ClientCertificate::class));
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testStore()
    {
        $this->repositoryMock->shouldReceive('store')->andReturn(Mockery::mock(ClientCertificate::class));

        $request = ClientCertificatesRequest::create(
            '/admin/client_certificates',
            ClientCertificatesRequest::METHOD_POST,
            [
                'certificate' => '@file',
                'private_key' => '@file',
                'private_key_pass' => '',
            ]
        );

        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertNotEmpty($response->getSession()->get('success'));
        $this->assertEmpty($response->getSession()->get('errors'));
    }

    public function testStoreFail()
    {
        $this->repositoryMock->shouldReceive('store')->andThrow(
            GameapException::class
        );

        $request = ClientCertificatesRequest::create(
            '/admin/client_certificates/',
            ClientCertificatesRequest::METHOD_POST,
            [
                'certificate' => '@file',
                'private_key' => '@file',
                'private_key_pass' => '',
            ]
        );

        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getSession()->get('success'));
        $this->assertNotEmpty($response->getSession()->get('errors'));
    }

    public function testDestroy()
    {
        $this->repositoryMock->shouldReceive('destroy')->andReturnNull();

        $response = $this->controller->destroy(Mockery::mock(ClientCertificate::class));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertNotEmpty($response->getSession()->get('success'));
    }
}