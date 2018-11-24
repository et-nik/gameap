@php($title = "Edit Dedicated server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#scripts">Scripts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#gdaemon">GDaemon</a>
        </li>
    </ul>
    
    {!! Form::model($dedicatedServer, ['method' => 'PATCH', 'route' => ['admin.dedicated_servers.update', $dedicatedServer->id]]) !!}
    <div class="tab-content">
        <div class="tab-pane container active" id="main">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light mt-3 mb-3">
                        <div class="card-body">
                            {{ Form::bsText('name') }}
                            {{ Form::bsText('enabled') }}
                            {{ Form::bsText('os') }}
                            {{ Form::bsText('location') }}
                            {{ Form::bsText('provider') }}

                            {{ Form::bsText('ram') }}
                            {{ Form::bsText('cpu') }}
                            {{ Form::bsText('work_path') }}
                            {{ Form::bsText('steamcmd_path') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-light mt-3 mb-3">
                        <div class="card-header">
                            IP List
                        </div>
                        <div class="card-body">
                            <input-text-list :initial-items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container-fluid fade" id="scripts">
            <div class="col-md-12">
                <div class="card bg-light mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">{{ Form::bsText('script_install') }}</div>
                            <div class="col-6">{{ Form::bsText('script_reinstall') }}</div>

                            <div class="col-6">{{ Form::bsText('script_update') }}</div>
                            <div class="col-6">{{ Form::bsText('script_start') }}</div>

                            <div class="col-6">{{ Form::bsText('script_pause') }}</div>
                            <div class="col-6">{{ Form::bsText('script_unpause') }}</div>

                            <div class="col-6">{{ Form::bsText('script_stop') }}</div>
                            <div class="col-6">{{ Form::bsText('script_kill') }}</div>

                            <div class="col-6">{{ Form::bsText('script_restart') }}</div>
                            <div class="col-6">{{ Form::bsText('script_status') }}</div>

                            <div class="col-6">{{ Form::bsText('script_get_console') }}</div>
                            <div class="col-6">{{ Form::bsText('script_send_command') }}</div>

                            <div class="col-6">{{ Form::bsText('script_delete') }}</div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <h5>Game Server Shortcodes</h5>
                                <ul>
                                    <li>{host} — server host/ip</li>
                                    <li>{port} — server port</li>
                                    <li>{query_port} — server query port</li>
                                    <li>{rcon_port} — server rcon port</li>
                                    <li>{dir} — absolute path to server directory</li>
                                    <li>{uuid} — unique id</li>
                                    <li>{uuid_short} — short unique id</li>
                                    <li>{game} — game code</li>
                                    <li>{user} — user name (exist user in dedicated server, not admin panel)</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <h5>Start/Restart Shortcodes</h5>
                                <ul>
                                    <li>{command} — Game server start command</li>
                                </ul>

                                <h5>Script Send Command</h5>
                                <ul>
                                    <li>{command} — Console command</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container fade" id="gdaemon">
            <div class="col-md-12">
                <div class="card bg-light mt-3 mb-3">
                    <div class="card-body">
                        {{ Form::bsText('gdaemon_host') }}
                        {{ Form::bsText('gdaemon_login') }}
                        {{ Form::bsText('gdaemon_password') }}
                        {{ Form::bsText('gdaemon_privkey') }}
                        {{ Form::bsText('gdaemon_pubkey') }}
                        {{ Form::bsText('gdaemon_keypass') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
