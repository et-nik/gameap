@php($title = "Edit Server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">Servers</a></li>
        <li class="breadcrumb-item active">Edit server</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="btn btn-large btn-light" href="{{ route('admin.servers_settings.edit', ['server' => $server->id]) }}">
            <span class="fa fa-cogs"></span>&nbsp;Settings
        </a>

        <a class="btn btn-large btn-light" href="{{ route('servers.control', ['server' => $server->id]) }}">
            <span class="fa fa-chalkboard"></span>&nbsp;Control
        </a>
    </div>


    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers.update', $server->id], 'id' => 'adminServerForm']) !!}
    <div class="col-md-6">
        {{ Form::bsText('name') }}
        {{ Form::bsText('code_name') }}

        <div class="form-group" id="dedicatedServerForm">
            {{ Form::label('ds_id', 'Dedicated server', ['class' => 'control-label']) }}
            {{ Form::select('ds_id', $dedicatedServers, null, ['class' => 'form-control', 'v-on:change' => 'dsChangeHandler', 'v-model' => 'dsId']) }}
        </div>

        <div class="form-group">
            <template id="ip-list-template">
                {{ Form::label('server_ip', 'IP', ['class' => 'control-label']) }}

                <select class='form-control' id='server_ip' name='server_ip'>
                    <option :value="ip" v-for="ip in ipList">@{{ip}}</option>
                </select>
            </template>
        </div>

        {{ Form::bsText('server_port') }}

        {{--{{ Form::bsText('query_port') }}--}}
        {{--{{ Form::bsText('rcon_port') }}--}}

        <div class="form-group">
            {{ Form::label('game_id', 'Game', ['class' => 'control-label']) }}
            {{ Form::select('game_id', $games, null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <template id="game-mod-list-template">
                {{ Form::label('game_mod_id', 'Game Mod', ['class' => 'control-label']) }}

                <select class="form-control" id="game_mod_id" name="game_mod_id">
                    <option :value="gameMod.id" v-for="gameMod in gameModsList">@{{gameMod.name}}</option>
                </select>
            </template>
        </div>

        {{ Form::bsText('rcon') }}
        {{ Form::bsText('dir') }}
        {{ Form::bsText('su_user') }}
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection