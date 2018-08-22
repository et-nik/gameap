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
    
    {!! Form::model($dedicatedServer, ['method' => 'PATCH', 'route' => ['admin.dedicated_servers.update', $dedicatedServer->id]]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light mb-3">
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
            <div class="card bg-light mb-3">
                <div class="card-header">
                    IP List
                </div>
                <div class="card-body">
                    <input-text-list :initial-items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-md-offset-2">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    {{ Form::bsText('script_start') }}
                    {{ Form::bsText('script_stop') }}
                    {{ Form::bsText('script_restart') }}
                    {{ Form::bsText('script_status') }}
                    {{ Form::bsText('script_get_console') }}
                    {{ Form::bsText('script_send_command') }}
                </div>
            </div>
        </div>
    
        <div class="col-md-12">
            <div class="card bg-light mb-3">
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
    
    
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
