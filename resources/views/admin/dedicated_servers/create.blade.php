@php($title = __('dedicated_servers.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ __('dedicated_servers.create') }}</li>
    </ol>
@endsection

@section('footer-scripts')
    <script>
        window.addEventListener('load', function() {
            var modal = new bootstrap.Modal('#gdaemonAutoSetupModal');
            modal.toggle();
        });
    </script>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="modal fade" tabindex="-1" role="dialog" id="gdaemonAutoSetupModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('dedicated_servers.autosetup_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('main.close') }}">
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#auto_install_debian_ubuntu">Debian/Ubuntu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#auto_install_windows">Windows</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="row tab-pane container-fluid active" id="auto_install_debian_ubuntu">
                            <div class="col-md-12 m-3">
                                {!! __('dedicated_servers.autosetup_description_debian_ubuntu') !!}
                                <code>curl {{ route('gdaemon.setup', ['token' => $autoSetupToken]) }} | bash --</code>

                                <p class="text-center"><small>{{ __('dedicated_servers.autosetup_expire_msg') }}</small></p>
                            </div>
                        </div>

                        <div class="row tab-pane container-fluid" id="auto_install_windows">
                            <div class="col-md-12 m-3">

                                {!! __('dedicated_servers.autosetup_description_windows', [
                                    'host' => request()->getSchemeAndHttpHost(),
                                    'token' => $autoSetupToken
                                    ])
                                !!}

                                <p class="text-center"><small>{{ __('dedicated_servers.autosetup_expire_token_msg') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['url' => route('admin.dedicated_servers.index'), 'files' => true]) !!}

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light mt-3 mb-3">
                    <div class="card-body">
                        {{ Form::bsText('name') }}
                        {{ Form::bsText('enabled') }}
                        {{ Form::bsText('os') }}

                        <div class="row">
                            <div class="col-md-6">{{ Form::bsText('location') }}</div>
                            <div class="col-md-6">{{ Form::bsText('provider') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">{{ Form::bsText('ram') }}</div>
                            <div class="col-md-6">{{ Form::bsText('cpu') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">{{ Form::bsText('work_path') }}</div>
                            <div class="col-md-6">{{ Form::bsText('steamcmd_path') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
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
            <div class="card-header">
                GDaemon
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-4">{{ Form::bsText('gdaemon_host') }}</div>
                            <div class="col-md-2">{{ Form::bsText('gdaemon_port') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">{{ Form::bsText('gdaemon_login') }}</div>
                            <div class="col-md-6">{{ Form::bsText('gdaemon_password') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-4 mb-3 pt-1">
                                <div class="input-group" id="serverCertificateForm">
                                    {{ Form::file('gdaemon_server_cert', ['class' => 'form-control']) }}
                                    {{ Form::label('gdaemon_server_cert', __('dedicated_servers.server_certificate'), ['class' => 'input-group-text']) }}

                                    @if ($errors->has('gdaemon_server_cert'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gdaemon_server_cert') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3" id="clientCertificateForm">
                                    {{ Form::label('client_certificates', __('dedicated_servers.client_certificate'), ['class' => 'control-label']) }}
                                    {{ Form::select('client_certificate_id', $clientCertificates , null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-2 offset-md-5">
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#editScripts" role="button" aria-expanded="false" aria-controls="editScripts">
                    {{ __('dedicated_servers.edit_scripts') }}
                </a>
            </div>

            <div class="col-md-12">
                <div class="collapse" id="editScripts">
                    <div class="card bg-light mt-3 mb-3">
                        <div class="card-header">{{ __('dedicated_servers.scripts') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">{{ Form::bsText('script_install') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_reinstall') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_update') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_start') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_pause') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_unpause') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_stop') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_kill') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_restart') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_status') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_get_console') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_send_command') }}</div>

                                <div class="col-md-6">{{ Form::bsText('script_delete') }}</div>
                                <div class="col-md-6">{{ Form::bsText('script_stats') }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @include('admin.dedicated_servers.shortcodes_description')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    {{ Form::submit(__('dedicated_servers.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection

