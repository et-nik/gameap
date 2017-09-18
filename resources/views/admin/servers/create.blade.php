@php($title = "Edit Server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.servers.index') }}">Servers</a></li>
        <li>Create</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.servers.index')]) !!}
    <div class="col-md-6">
        {{ Form::bsText('name') }}
        {{ Form::bsText('code_name') }}

        <div class="form-group">
            {{ Form::label('ds_id', 'Dedicated server', ['class' => 'control-label']) }}
            {{ Form::select('ds_id', $dedicatedServers, null, ['class' => 'form-control']) }}
        </div>

        <div id="app">

        </div>

        {{--TODO: Autoload Dedicated server IP list--}}
        {{ Form::bsText('server_ip') }}
        {{ Form::bsText('server_port') }}

        {{--{{ Form::bsText('query_port') }}--}}
        {{--{{ Form::bsText('rcon_port') }}--}}

        <div class="form-group">
            {{ Form::label('game_id', 'Game', ['class' => 'control-label']) }}
            {{ Form::select('game_id', $games, null, ['class' => 'form-control']) }}
        </div>

        {{--TODO: Autoload games mods for selected games--}}
        {{--<div class="form-group">--}}
        {{--{{ Form::label('game_mod_id', 'Game Mod', ['class' => 'control-label']) }}--}}
        {{--{{ Form::select('game_mod_id', $gamesMods, null, ['class' => 'form-control']) }}--}}
        {{--</div>--}}

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