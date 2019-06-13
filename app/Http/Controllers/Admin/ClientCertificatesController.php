<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Exceptions\GameapException;
use Gameap\Http\Controllers\AuthController;
use Gameap\Models\ClientCertificate;
use Gameap\Repositories\ClientCertificateRepository;
use Gameap\Http\Requests\ClientCertificatesRequest;

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
    public function index()
    {
        $clientCertificates = $this->repository->getAll();

        return view('admin.client_certificates.list', compact('clientCertificates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.client_certificates.create', compact('clientCertificates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Gameap\Http\Requests\ClientCertificatesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientCertificatesRequest $request)
    {
        try {
            $this->repository->store($request);

            return redirect()->route('admin.client_certificates.index')
                ->with('success', __('client_certificates.create_success_msg'));
        } catch (GameapException $e) {
            return redirect()->back()
                ->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\ClientCertificate  $clientCertificate
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(ClientCertificate $clientCertificate)
    {
        $certificateInfo = $this->repository->certificateInfo($clientCertificate);
        
        return view('admin.client_certificates.view', compact('clientCertificate', 'certificateInfo'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\ClientCertificate  $clientCertificate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ClientCertificate $clientCertificate)
    {
        $this->repository->destroy($clientCertificate);

        return redirect()->route('admin.client_certificates.index')
            ->with('success',  __('client_certificates.delete_success_msg'));
    }
}