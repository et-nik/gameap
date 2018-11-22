@php($title = 'Game server')

@extends('layouts.main')

@section('content')
    <div class="row mt-2">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Commands</h3>
                </div>

                <div class="card-body">
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
                </div>
                
            </div>
        </div>
        
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Tools</h3>
                </div>
                
                <div class="card-body">
                    <a class="btn btn-large btn-light" href="{{ route('servers.filemanager', ['server' => $server->id]) }}">
                        <span class="fa fa-folder-open"></span>&nbsp;Files
                    </a>

                    @can('admin roles & permissions')
                        <a class="btn btn-large btn-danger" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
                            <span class="fa fa-hammer"></span>&nbsp;Admin
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Proccess status</h3>
                </div>
                    <ul class="list-group list-group-flush">
                        @if (!$server->processActive())
                            <li class="list-group-item">Status: <span class="badge badge-success">active</span></li>
                        @else
                            <li class="list-group-item">Status: <span class="badge badge-danger">inactive</span></li>
                        @endif
                            <li class="list-group-item">Last check: {{ $server->last_process_check }}</li>
                    </ul>

            </div>
        </div>
        
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Query</h3>
                </div>
                <server-status :server-id="{{ $server->id }}"></server-status>
            </div>
        </div>
    </div>
    
@endsection