@php($title = "Create Dedicated server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.dedicated_servers.index')]) !!}

        <div class="row">
            <div class="col-6">
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

            <div class="col-6">
                <div class="card bg-light mt-3 mb-3">
                    <div class="card-header">
                        IP List
                    </div>
                    <div class="card-body">
                        @php ( $oldIpValue = old('ip') ? json_encode(old('ip')) : '[]' )
                        <input-text-list :initial-items="{{ $oldIpValue }}" name="ip" label="IP"></input-text-list>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-light mt-3 mb-3">
            <div class="card-header">Scripts</div>
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
                    <div class="col-6">{{ Form::bsText('script_stats') }}</div>
                </div>
            </div>
            <div class="card-footer">
                @include('admin.dedicated_servers.shortcodes_description')
            </div>
        </div>

        <div class="card bg-light mt-3 mb-3">
            <div class="card-header">
                GDaemon
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        {{ Form::bsText('gdaemon_host') }}
                        {{ Form::bsText('gdaemon_port') }}
                        {{ Form::bsText('gdaemon_login') }}
                        {{ Form::bsText('gdaemon_password') }}
                        {{ Form::bsText('gdaemon_server_cert') }}

                        <div class="form-group" id="clientCertificateForm">
                            {{ Form::label('client_certificates', 'Client Certificate', ['class' => 'control-label']) }}
                            {{ Form::select('ds_id', $clientCertificates , null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection
