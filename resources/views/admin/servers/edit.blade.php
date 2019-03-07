@php($title = __('servers.title_edit'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('servers.edit') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="btn btn-large btn-light" href="{{ route('admin.servers_settings.edit', ['server' => $server->id]) }}">
            <span class="fa fa-cogs"></span>&nbsp;{{ __('servers.settings') }}
        </a>

        <a class="btn btn-large btn-light" href="{{ route('servers.control', ['server' => $server->id]) }}">
            <span class="fa fa-chalkboard"></span>&nbsp;{{ __('servers.control') }}
        </a>
    </div>


    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers.update', $server->id], 'id' => 'adminServerForm']) !!}
        <div class="row mt-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('servers.basic_info') }}
                    </div>
                    <div class="card-body">
                        {{ Form::bsText('uuid', null, null, ['disabled' => 'disabled']) }}
                        {{ Form::bsText('name') }}

                        <div class="form-group">
                            {{ Form::label('game_id', __('servers.game'), ['class' => 'control-label']) }}
                            {{ Form::select('game_id', $games, null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            <template id="game-mod-list-template">
                                {{ Form::label('game_mod_id', __('servers.game_mod'), ['class' => 'control-label']) }}

                                <select class="form-control" id="game_mod_id" name="game_mod_id">
                                    <option :value="gameMod.id" :selected="gameMod.id == {{ $server->game_mod_id }}" v-for="gameMod in gameModsList">@{{gameMod.name}}</option>
                                </select>
                            </template>
                        </div>

                        {{ Form::bsText('rcon') }}
                        {{ Form::bsText('dir') }}
                        {{ Form::bsText('su_user') }}
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('servers.ds_ip_ports') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="dedicatedServerForm">
                            {{ Form::label('ds_id', __('servers.dedicated_server'), ['class' => 'control-label']) }}
                            {{ Form::select('ds_id', $dedicatedServers, null, ['class' => 'form-control', 'v-on:change' => 'dsChangeHandler', 'v-model' => 'dsId']) }}
                        </div>

                        <div class="form-group">
                            <template id="ip-list-template">
                                {{ Form::label('server_ip', 'IP', ['class' => 'control-label']) }}

                                <select class='form-control' id='server_ip' name='server_ip'>
                                    <option :value="ip" :selected="ip == '{{ $server->server_ip }}'" v-for="ip in ipList">@{{ip}}</option>
                                </select>
                            </template>
                        </div>

                        {{ Form::bsText('server_port') }}
                        {{ Form::bsText('query_port') }}
                        {{ Form::bsText('rcon_port') }}
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        {{ __('servers.start_command') }}
                    </div>
                    <div class="card-body">
                        {{ Form::bsText('start_command') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection