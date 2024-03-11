@php($title = __('dedicated_servers.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('dedicated_servers.dedicated_servers') }}</li>
    </ol>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600' href="{{ route('admin.dedicated_servers.create') }}">
            <i class="fa fa-plus-square"></i> {{ __('dedicated_servers.create') }}
        </a>&nbsp;
        <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500' href="{{ route('admin.client_certificates.index') }}">
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
