@php($title = __('client_certificates.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.dedicated_servers.index") }}', 'text':'{{ __("dedicated_servers.dedicated_servers") }}'},
        {'text':'{{ __("client_certificates.client_certificates") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <a class='inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-lime-500 text-white hover:bg-lime-600' href="{{ route('admin.client_certificates.create') }}">
        <i class="fa fa-plus-square"></i>&nbsp;{{ __('client_certificates.create') }}
    </a>
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
