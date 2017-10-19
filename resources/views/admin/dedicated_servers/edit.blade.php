@php($title = "Edit Dedicated server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li>Create</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($dedicatedServer, ['method' => 'PATCH', 'route' => ['admin.dedicated_servers.update', $dedicatedServer->id]]) !!}
    <div class="col-md-6">
        {{ Form::bsText('name') }}
        {{ Form::bsText('enabled') }}
        {{ Form::bsText('os') }}
        {{ Form::bsText('location') }}
        {{ Form::bsText('provider') }}
        @foreach ($dedicatedServer->ip as $ip)
            {{ Form::bsText('ip[]', $ip, 'IP') }}
        @endforeach

        {{ Form::bsText('ram') }}
        {{ Form::bsText('cpu') }}
        {{ Form::bsText('work_path') }}
        {{ Form::bsText('steamcmd_path') }}
    </div>

    <div class="col-md-6">
        {{ Form::bsText('script_start') }}
        {{ Form::bsText('script_stop') }}
        {{ Form::bsText('script_restart') }}
        {{ Form::bsText('script_status') }}
        {{ Form::bsText('script_get_console') }}
        {{ Form::bsText('script_send_command') }}
    </div>

    <div class="col-md-12">
        {{ Form::bsText('gdaemon_host') }}
        {{ Form::bsText('gdaemon_login') }}
        {{ Form::bsText('gdaemon_password') }}
        {{ Form::bsText('gdaemon_privkey') }}
        {{ Form::bsText('gdaemon_pubkey') }}
        {{ Form::bsText('gdaemon_keypass') }}
    </div>


    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection
