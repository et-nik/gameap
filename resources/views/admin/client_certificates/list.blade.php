@php($title = __('client_certificates.title_list'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ __('client_certificates.client_certificates') }}</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.client_certificates.create') }}">{{ __('client_certificates.create') }}</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $clientCertificates,
        'labels' => [
                    __('client_certificates.fingerprint'),
                    __('client_certificates.expires'),
        ],
        'attributes' => ['fingerprint', 'expires'],
        'viewRoute' => 'admin.client_certificates.show',
        'destroyRoute' => 'admin.client_certificates.destroy',
    ])

    {!! $clientCertificates->links() !!}
@endsection