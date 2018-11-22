@php($title = 'Game server')

@extends('layouts.main')

@section('content')
    <h2>Commands</h2>
    <div id="serverControl">
        @if (!$server->processActive())
            <a class="btn btn-large btn-success" href="#" @click="startServer({{ $server->id }})">
                <span class="fas fa-play"></span>&nbsp;Start
            </a>
        @endif

        @if ($server->processActive())
            <a class="btn btn-large btn-danger" href="#" @click="stopServer({{ $server->id }})">
                <span class="fas fa-stop"></span>&nbsp;Stop
            </a>
        @endif

        <a class="btn btn-large btn-warning" href="#" @click="restartServer({{ $server->id }})">
            <span class="fas fa-redo"></span>&nbsp;Restart
        </a>
        <a class="btn btn-large btn-info" href="#" @click="updateServer({{ $server->id }})">
            <span class="fas fa-sync"></span>&nbsp;Update
        </a>
    </div>
    
    <h2>Tools</h2>
    <a class="btn btn-large btn-light" href="{{ route('servers.filemanager', ['server' => $server->id]) }}">
        <span class="fa fa-folder-open"></span>&nbsp;Files
    </a>

    @can('admin roles & permissions')
        <a class="btn btn-large btn-danger" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
            <span class="fa fa-hammer"></span>&nbsp;Admin
        </a>
    @endcan


    <h2>Status</h2>

    <server-status :server-id="{{ $server->id }}"></server-status>
@endsection