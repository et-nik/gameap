@php($title = 'Dedicated servers list')

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">Dedicated servers</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.dedicated_servers.create') }}">Create</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $dedicatedServers,
        'labels' => ['Name', 'Location', 'Provider', 'IP', 'OS', 'Servers count'],
        'attributes' => ['name', 'location', 'provider', 'ip', 'os', 'servers_count'],
        'viewRoute' => 'admin.dedicated_servers.show',
        'editRoute' => 'admin.dedicated_servers.edit',
        'destroyRoute' => 'admin.dedicated_servers.destroy',
    ])

    {!! $dedicatedServers->links() !!}
@endsection