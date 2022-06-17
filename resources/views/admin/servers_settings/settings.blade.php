@php($title = 'Game server settings')

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">{{ $server->name }}</a></li>
        <li class="breadcrumb-item active">{{ __('servers.settings') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
        {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers_settings.update', $server->id]]) !!}

        <settings-parameters
                :initial-items="{{ $settings->toJson() }}"
                input-name="settings">
        </settings-parameters>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection