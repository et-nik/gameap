@php($title = __('client_certificates.title_view'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('admin.client_certificates.index') }}">{{ __('client_certificates.client_certificates') }}</a></li>
        <li class="breadcrumb-item active">{{ __('client_certificates.view') }}</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th class="w-25">{{ __('client_certificates.fingerprint') }}</th>
                        <td>{!! $clientCertificate->fingerprint !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th class="w-25">{{ __('client_certificates.signature_type') }}</th>
                        <td>{!! $certificateInfo['signature_type'] !!}</td>
                    </tr>                    
                    <tr>
                        <th>{{ __('client_certificates.common_name') }}</th>
                        <td>{!! $certificateInfo['common_name'] !!}</td>
                    </tr>   
                    <tr>
                        <th>{{ __('client_certificates.email') }}</th>
                        <td>{!! $certificateInfo['email'] !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('client_certificates.expires') }}</th>
                        <td>{!! $certificateInfo['expires'] !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    {{ __('client_certificates.used') }}
                </div>
                
                @include('components.grid', [
                        'modelsList' => $clientCertificate->dedicatedServers,
                        'labels' => [
                                    __('dedicated_servers.name'),
                                    __('dedicated_servers.ip'),
                                    __('dedicated_servers.os'),
                                    __('dedicated_servers.servers_count')
                        ],
                        'attributes' => ['name', 'ip', 'os', 'servers_count'],
                        'viewRoute' => 'admin.dedicated_servers.show',
                        'editRoute' => 'admin.dedicated_servers.edit'
                    ])
            </div>
        </div>
    </div>
@endsection
