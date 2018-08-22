@php($title = 'Games servers list')

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">Game servers</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.servers.create') }}">Create</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $servers,
        'labels' => ['Name', 'Game', 'IP:Port'],
        'attributes' => ['name', 'game.name', ['twoSeparatedValues', ['server_ip', ':', 'server_port']]],
        'viewRoute' => 'admin.servers.show',
        'editRoute' => 'admin.servers.edit',
        'destroyRoute' => 'admin.servers.destroy',
    ])

    {!! $servers->links() !!}
@endsection