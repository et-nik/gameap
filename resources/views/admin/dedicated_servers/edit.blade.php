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
        
        {{ Form::bsText('ram') }}
        {{ Form::bsText('cpu') }}
        {{ Form::bsText('work_path') }}
        {{ Form::bsText('steamcmd_path') }}
    </div>
    
    <div class="col-md-6">
        <div id="ip-list">
            
        </div>
        {{-- https://jsfiddle.net/p4xLg8o0/ --}}
        {{-- https://jsfiddle.net/p4xLg8o0/3/ --}}
        
        {{--<input-text-list :items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>--}}
        <input-text-list :initial-items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>
    </div>

    <div class="col-md-6 col-md-offset-2">
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
