@php($title = __('client_certificates.title_view'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.client_certificates.index') }}">{{ __('client_certificates.client_certificates') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('client_certificates.view') }}</li>
    </ol>
@endsection

@section('content')

    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th class="w-1/4">{{ __('client_certificates.fingerprint') }}</th>
                        <td>{!! $clientCertificate->fingerprint !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="md:w-full pr-4 pl-4">
            <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th class="w-1/4">{{ __('client_certificates.signature_type') }}</th>
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
    
    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-3 mb-3">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
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
