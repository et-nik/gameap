<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Session;
use Tests\TestCase;


/**
 * @covers \Gameap\Http\Controllers\Admin\ClientCertificatesController
 */
class ClientCertificatesControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        // Index
        $response = $this->get(route('admin.client_certificates.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.client_certificates.list');

        // Create
        $response = $this->get(route('admin.client_certificates.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.client_certificates.create');
        $response->assertSeeText(__('client_certificates.title_create'));

        // Store
        // TODO: Add Valid certificate and key
        $response = $this->post(route('admin.client_certificates.store'), [
            '_token' => Session::token(),
            'certificate' => UploadedFile::fake()->create('certificate.csr', 1),
            'private_key' => UploadedFile::fake()->create('certificate.key', 1),
            'private_key_pass' => '',
        ]);
        $response->assertStatus(Response::HTTP_FOUND);
        // TODO: Add route redirect
        // $response->isRedirect(route('admin.client_certificates.index'));
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['user']);

        // Index
        $response = $this->get(route('admin.client_certificates.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.client_certificates.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertDontSeeText(__('client_certificates.title_create'));

        // Store
        $response = $this->post(route('admin.client_certificates.store'), [
            '_token' => Session::token(),
            'certificate' => UploadedFile::fake()->create('certificate.csr', 1),
            'private_key' => UploadedFile::fake()->create('certificate.key', 1),
            'private_key_pass' => '',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAdminForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        // Index
        $response = $this->get(route('admin.client_certificates.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.client_certificates.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertDontSeeText(__('client_certificates.title_create'));

        // Store
        $response = $this->post(route('admin.client_certificates.store'), [
            '_token' => Session::token(),
            'certificate' => UploadedFile::fake()->create('certificate.csr', 1),
            'private_key' => UploadedFile::fake()->create('certificate.key', 1),
            'private_key_pass' => '',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
