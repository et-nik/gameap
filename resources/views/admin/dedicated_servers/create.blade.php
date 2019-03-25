@php($title = __('dedicated_servers.title_create'))

@extends('layouts.main')

@section('breadclumbs')
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

{{-- TODO: Move filename fix --}}
@section('footer-scripts')
    <script>
        $(window).on('load',function(){
            $('#gdaemonAutoSetupModal').modal('toggle');
            
            $('.custom-file-input').on('change',function(){
                var fileName = $(this).val();
                fileName = fileName.replace(/^.*\\/, "");
                $(this).next('.custom-file-label').html(fileName);
            });
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('main.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#auto_install_debian_ubuntu">Debian/Ubuntu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#auto_install_windows">Windows</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="row tab-pane container-fluid active" id="auto_install_debian_ubuntu">
                            <div class="col-12 m-3">
                                {!! __('dedicated_servers.autosetup_description_debian_ubuntu') !!}
                                <code>curl {{ route('gdaemon.setup', ['token' => $autoSetupToken]) }} | bash --</code>

                                <p class="text-center"><small>{{ __('dedicated_servers.autosetup_expire_msg') }}</small></p>
                            </div>
                        </div>

                        <div class="row tab-pane container-fluid" id="auto_install_windows">
                            <div class="col-12 m-3">

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['url' => route('admin.dedicated_servers.index'), 'files' => true]) !!}

        <div class="row">
            <div class="col-6">
                <div class="card bg-light mt-3 mb-3">
                    <div class="card-body">
                        {{ Form::bsText('name') }}
                        {{ Form::bsText('enabled') }}
                        {{ Form::bsText('os') }}

                        <div class="row">
                            <div class="col-6">{{ Form::bsText('location') }}</div>
                            <div class="col-6">{{ Form::bsText('provider') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-6">{{ Form::bsText('ram') }}</div>
                            <div class="col-6">{{ Form::bsText('cpu') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-6">{{ Form::bsText('work_path') }}</div>
                            <div class="col-6">{{ Form::bsText('steamcmd_path') }}</div>
                        </div>
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
            <div class="card-header">
                GDaemon
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-4">{{ Form::bsText('gdaemon_host') }}</div>
                            <div class="col-2">{{ Form::bsText('gdaemon_port') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-6">{{ Form::bsText('gdaemon_login') }}</div>
                            <div class="col-6">{{ Form::bsText('gdaemon_password') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-6 mt-4 mb-3 pt-1">
                                <div class="custom-file" id="serverCertificateForm">
                                    {{ Form::file('gdaemon_server_cert', ['class' => 'custom-file-input']) }}
                                    {{ Form::label('gdaemon_server_cert', __('dedicated_servers.server_certificate'), ['class' => 'custom-file-label']) }}

                                    @if ($errors->has('gdaemon_server_cert'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gdaemon_server_cert') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group" id="clientCertificateForm">
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
            <div class="col-2 offset-5">
                <a class="btn btn-primary" data-toggle="collapse" href="#editScripts" role="button" aria-expanded="false" aria-controls="editScripts">
                    {{ __('dedicated_servers.edit_scripts') }}
                </a>
            </div>

            <div class="col-12">
                <div class="collapse" id="editScripts">
                    <div class="card bg-light mt-3 mb-3">
                        <div class="card-header">{{ __('dedicated_servers.scripts') }}</div>
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{ Form::submit(__('dedicated_servers.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection

