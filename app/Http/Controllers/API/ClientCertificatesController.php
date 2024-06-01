<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\ClientCertificatesRequest;
use Gameap\Models\ClientCertificate;
use Gameap\Repositories\ClientCertificateRepository;

class ClientCertificatesController extends AuthController
{
    /**
     * The ClientCertificateRepository instance.
     *
     * @var \Gameap\Repositories\ClientCertificateRepository
     */
    protected $repository;

    /**
     * Create a new ClientCertificatesController instance.
     *
     * @param  \Gameap\Repositories\ClientCertificateRepository $repository
     */
    public function __construct(ClientCertificateRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $clientCertificates = $this->repository->getAll(99999);

        return $clientCertificates->map(function ($item) {
            return $item->only([
                'id',
                'fingerprint',
                'expires',
                'info',
            ]);
        });
    }

    public function store(ClientCertificatesRequest $request)
    {
        $this->repository->store($request);

        return ['message' => 'success'];
    }

    public function destroy($id)
    {
        $clientCertificate = $this->repository->findById($id);

        $this->repository->destroy($clientCertificate);

        return ['message' => 'success'];
    }
}