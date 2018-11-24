@php($title = "Edit Server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">Servers</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.servers.index'), 'id' => 'adminServerForm']) !!}
    <div class="col-md-6">
        {{ Form::bsText('name') }}

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
            {{ Form::select('game_id', $games, null, ['class' => 'form-control', 'v-on:change' => 'gameChangeHandler', 'v-model' => 'gameId']) }}
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
            {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection