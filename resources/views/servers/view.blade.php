@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item">{{ $server->name }}&nbsp;&nbsp;<span class="text-muted">{{ $server->game->name }}</span></li>
    </ol>
@endsection

@section('content')
    <ul class="nav nav-tabs large mt-4">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" data-tab="main" href="#main">
                <i class="fas fa-play"></i>
                {{ __('servers.control') }}
            </a>
        </li>

        @can('server-files', $server)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-tab="filemanager" href="#filemanager">
                    <i class="fa fa-folder-open"></i>
                    {{ __('servers.files') }}
                </a>
            </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" data-tab="schedules" href="#schedules">
                <i class="far fa-calendar-alt"></i>
                {{ __('servers.task_scheduler') }}
            </a>
        </li>

        @can('server-settings', $server)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-tab="settings" href="#settings">
                    <i class="fa fa-cogs"></i>
                    {{ __('servers.settings') }}
                </a>
            </li>
        @endcan

        @can('admin roles & permissions')
            <li class="nav-item ml-auto">
                <a class="nav-link text-danger" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
                    <i class="fa fa-hammer"></i>
                    {{ __('servers.admin') }}
                </a>
            </li>
        @endcan

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
            </div>

            <div class="row mt-2">
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
                    <server-tasks v-if="activeTab === 'schedules'" :server-id="{{ $server->id }}"></server-tasks>
                </div>
            </div>
        </div>

        <div class="row tab-pane container-fluid fade" id="filemanager">
            <div class="row mt-2">
                <div class="col-12">
                    <file-manager v-if="activeTab === 'filemanager'" server-id="{{ $server->id }}"></file-manager>
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

@section('footer-scripts')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            window.gameap.activeTab = $(e.target).data('tab');
        })
    </script>
@endsection