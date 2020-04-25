@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#main">Control</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#schedules">Schedules</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#files">
                <i class="fa fa-folder-open"></i>
                File Manager
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#settings">
                <i class="fa fa-cogs"></i>
                Settings
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#settings">FastDL</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#settings">FTP</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            <div class="row mt-2">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('servers.commands') }}</h3>
                        </div>

                        <div class="card-body">
                            <div id="serverControl">
                                @can('server-start', $server)
                                    @if (!$server->processActive())
                                        <a class="btn btn-large btn-success m-1" href="#" @click="startServer({{ $server->id }})">
                                            <span class="fas fa-play"></span>&nbsp;{{ __('servers.start') }}
                                        </a>
                                    @endif
                                @endcan

                                @can('server-stop', $server)
                                    @if ($server->processActive())
                                        <a class="btn btn-large btn-danger m-1" href="#" @click="stopServer({{ $server->id }})">
                                            <span class="fas fa-stop"></span>&nbsp;{{ __('servers.stop') }}
                                        </a>
                                    @endif
                                @endcan

                                @can('server-restart', $server)
                                    <a class="btn btn-large btn-warning m-1" href="#" @click="restartServer({{ $server->id }})">
                                        <span class="fas fa-redo"></span>&nbsp;{{ __('servers.restart') }}
                                    </a>
                                @endcan

                                @can('server-update', $server)
                                    <a class="btn btn-large btn-info m-1" href="#" @click="updateServer({{ $server->id }})">
                                        <span class="fas fa-sync"></span>&nbsp;{{ __('servers.update') }}
                                    </a>

                                    <a class="btn btn-large btn-dark m-1" href="#" @click="reinstallServer({{ $server->id }})">
                                        <span class="fas fa-reply-all"></span>&nbsp;{{ __('servers.reinstall') }}
                                    </a>
                                @endcan
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
                            @can('server-files', $server)
                                <a class="btn btn-large btn-light m-1" href="{{ route('servers.filemanager', ['server' => $server->id]) }}">
                                    <span class="fa fa-folder-open"></span>&nbsp;{{ __('servers.files') }}
                                </a>
                            @endcan

                            @can('server-settings', $server)
                                <a class="btn btn-large btn-light m-1" href="{{ route('servers.settings', ['server' => $server->id]) }}">
                                    <span class="fa fa-cogs"></span>&nbsp;{{ __('servers.settings') }}
                                </a>
                            @endcan

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

            @can('server-console-view', $server)
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
            @endcan
        </div>

        <div class="row tab-pane container-fluid fade" id="schedules">
            <div class="row mt-2">
                <div class="col-12">
                    <server-tasks :server-id="{{ $server->id }}"></server-tasks>
                </div>
            </div>
        </div>

        <div class="row tab-pane container-fluid fade" id="files">
            <div class="row mt-2">
                <div class="col-12">
                    <file-manager server-id="{{ $server->id }}"></file-manager>
                </div>
            </div>
        </div>

        <div class="row tab-pane container-fluid fade" id="settings">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($server, ['method' => 'PATCH', 'route' => ['servers.updateSettings', $server->id], 'id' => 'adminServerForm']) !!}

                            <div class="col-md-12">
                                <div class="form-check mt-4 mb-4">
                                    {{ Form::checkbox('autostart', true, $autostart, ['id' => 'autostart', 'class' => 'form-check-input']) }}
                                    {{ Form::label('autostart', __('servers.autostart_setting'), ['class' => 'form-check-label']) }}
                                </div>
                            </div>


                            @if(!empty($server->gameMod->vars))
                                @foreach ($server->gameMod->vars as $var)
                                    @if (isset($var['admin_var']) && $var['admin_var'])
                                        @cannot('admin roles & permissions')
                                            @continue
                                        @endcannot
                                    @endif

                                    <div class="col-md-12">
                                        {{ Form::bsText(
                                                'vars[' . $var['var'] . ']',
                                                (isset($server->vars[ $var['var'] ]))
                                                    ? $server->vars[ $var['var'] ]
                                                    : $var['default'],
                                                $var['info']
                                            ) }}
                                    </div>
                                @endforeach
                            @endif

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection