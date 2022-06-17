@php($title = __('dedicated_servers.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('dedicated_servers.dedicated_servers') }}</li>
    </ol>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='btn btn-success' href="{{ route('admin.dedicated_servers.create') }}">
            <i class="fa fa-plus-square"></i> {{ __('dedicated_servers.create') }}
        </a>
        <a class='btn btn-warning' href="{{ route('admin.client_certificates.index') }}">
            <i class="fas fa-certificate"></i> {{ __('client_certificates.client_certificates') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $dedicatedServers,
        'labels' => [
                    __('dedicated_servers.name'),
                    __('dedicated_servers.location'),
                    __('dedicated_servers.provider'),
                    __('dedicated_servers.ip'),
                    __('dedicated_servers.os'),
                    __('dedicated_servers.servers_count')
        ],
        'attributes' => ['name', 'location', 'provider', 'ip', 'os', 'servers_count'],
        'viewRoute' => 'admin.dedicated_servers.show',
        'editRoute' => 'admin.dedicated_servers.edit',
        'destroyRoute' => 'admin.dedicated_servers.destroy',
    ])

    {!! $dedicatedServers->links() !!}
@endsection