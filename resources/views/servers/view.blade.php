@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('content')
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('servers.commands') }}</h3>
                </div>

                <div class="card-body">
                    <div id="serverControl">
                        @if (!$server->processActive())
                            <a class="btn btn-large btn-success" href="#" @click="startServer({{ $server->id }})">
                                <span class="fas fa-play"></span>&nbsp;{{ __('servers.start') }}
                            </a>
                        @endif

                        @if ($server->processActive())
                            <a class="btn btn-large btn-danger" href="#" @click="stopServer({{ $server->id }})">
                                <span class="fas fa-stop"></span>&nbsp;{{ __('servers.stop') }}
                            </a>
                        @endif

                        <a class="btn btn-large btn-warning" href="#" @click="restartServer({{ $server->id }})">
                            <span class="fas fa-redo"></span>&nbsp;{{ __('servers.restart') }}
                        </a>

                        <a class="btn btn-large btn-info" href="#" @click="updateServer({{ $server->id }})">
                            <span class="fas fa-sync"></span>&nbsp;{{ __('servers.update') }}
                        </a>

                        <a class="btn btn-large btn-dark" href="#" @click="reinstallServer({{ $server->id }})">
                            <span class="fas fa-reply-all"></span>&nbsp;{{ __('servers.reinstall') }}
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('servers.tools') }}</h3>
                </div>
                
                <div class="card-body">
                    <a class="btn btn-large btn-light m-1" href="{{ route('servers.filemanager', ['server' => $server->id]) }}">
                        <span class="fa fa-folder-open"></span>&nbsp;{{ __('servers.files') }}
                    </a>

                    <a class="btn btn-large btn-light m-1" href="{{ route('servers.settings', ['server' => $server->id]) }}">
                        <span class="fa fa-cogs"></span>&nbsp;{{ __('servers.settings') }}
                    </a>

                    @can('admin roles & permissions')
                        <a class="btn btn-large btn-danger m-1" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
                            <span class="fa fa-hammer"></span>&nbsp;{{ __('servers.admin') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('servers.process_status') }}</h3>
                </div>
                    <ul class="list-group list-group-flush">
                        @if ($server->processActive())
                            <li class="list-group-item">{{ __('servers.status') }}: <span class="badge badge-success">{{ __('servers.active') }}</span></li>
                        @else
                            <li class="list-group-item">{{ __('servers.status') }}: <span class="badge badge-danger">{{ __('servers.inactive') }}</span></li>
                        @endif
                        
                        <li class="list-group-item">{{ __('servers.last_check') }}: {{ $server->last_process_check }}</li>
                    </ul>

            </div>
        </div>

        @if ($server->processActive())
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('servers.query') }}</h3>
                    </div>
                    <server-status :server-id="{{ $server->id }}">
                        <div class="d-flex justify-content-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </server-status>
                </div>
            </div>
        @endif
    </div>

    @if ($server->processActive())
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('servers.console') }}</h3>
                    </div>

                    <server-console console-hostname="{{ $server->uuid_short }}" :server-id="{{ $server->id }}">
                        <div class="d-flex justify-content-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </server-console>
                </div>
            </div>
        </div>
    @endif

@endsection