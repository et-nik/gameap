@php($title = __('dedicated_servers.title_list'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('dedicated_servers.dedicated_servers') }}</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.dedicated_servers.create') }}">{{ __('dedicated_servers.create') }}</a>
    <a class='btn btn-success btn-sm' href="{{ route('admin.client_certificates.index') }}">{{ __('client_certificates.list') }}</a>
    <hr>

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