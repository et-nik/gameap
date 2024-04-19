@php($title = __('dedicated_servers.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.dedicated_servers.index") }}', 'text':'{{ __("dedicated_servers.dedicated_servers") }}'},
        {'text':'{{ __("dedicated_servers.create") }}'},
    ]"></g-breadcrumbs>
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

    <div class="modal opacity-0" tabindex="-1" role="dialog" id="gdaemonAutoSetupModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('dedicated_servers.autosetup_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('main.close') }}">
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
                        <li class="">
                            <a class="inline-block py-2 px-4 no-underline active" data-bs-toggle="tab" href="#auto_install_linux"><i class="fab fa-linux me-1"></i>Linux</a>
                        </li>
                        <li class="">
                            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#auto_install_windows"><i class="fab fa-windows me-1"></i>Windows</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="flex flex-wrap  tab-pane container mx-auto sm:px-4 max-w-full mx-auto sm:px-4 active" id="auto_install_linux">
                            <div class="md:w-full pr-4 pl-4 m-6">
                                {!! __('dedicated_servers.autosetup_description_linux', [
                                    'host' => request()->getSchemeAndHttpHost(),
                                    'token' => $autoSetupToken
                                ]) !!}
                                <code class="curl-link">curl {{ route('gdaemon.setup', ['token' => $autoSetupToken]) }} | bash --</code>

                                <p class="text-center"><small>{{ __('dedicated_servers.autosetup_expire_msg') }}</small></p>
                            </div>
                        </div>

                        <div class="flex flex-wrap  tab-pane container mx-auto sm:px-4 max-w-full mx-auto sm:px-4" id="auto_install_windows">
                            <div class="md:w-full pr-4 pl-4 m-6">

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
                    <button type="button" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-gray-600 text-white hover:bg-gray-700" data-bs-dismiss="modal">{{ __('main.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['url' => route('admin.dedicated_servers.index'), 'files' => true]) !!}

        <div class="flex flex-wrap ">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                    <div class="flex-auto p-6">
                        {{ Form::bsText('name') }}
                        {{ Form::bsText('enabled') }}
                        {{ Form::bsText('os') }}

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('location') }}</div>
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('provider') }}</div>
                        </div>

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('ram') }}</div>
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('cpu') }}</div>
                        </div>

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('work_path') }}</div>
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('steamcmd_path') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        IP List
                    </div>
                    <div class="flex-auto p-6">
                        @php ( $oldIpValue = old('ip') ? json_encode(old('ip')) : '[]' )
                        <input-text-list :initial-items="{{ $oldIpValue }}" name="ip" label="IP"></input-text-list>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                GDaemon
            </div>
            <div class="flex-auto p-6">
                <div class="flex flex-wrap ">
                    <div class="md:w-full pr-4 pl-4">

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/3 pr-4 pl-4">{{ Form::bsText('gdaemon_host') }}</div>
                            <div class="md:w-1/5 pr-4 pl-4">{{ Form::bsText('gdaemon_port') }}</div>
                        </div>

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('gdaemon_login') }}</div>
                            <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('gdaemon_password') }}</div>
                        </div>

                        <div class="flex flex-wrap ">
                            <div class="md:w-1/2 pr-4 pl-4 mt-4 mb-3 pt-1">
                                <div class="relative flex items-stretch w-full" id="serverCertificateForm">
                                    {{ Form::file('gdaemon_server_cert', ['class' => 'form-control']) }}
                                    {{ Form::label('gdaemon_server_cert', __('dedicated_servers.server_certificate'), ['class' => 'input-group-text']) }}

                                    @if ($errors->has('gdaemon_server_cert'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gdaemon_server_cert') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="md:w-1/2 pr-4 pl-4">
                                <div class="mb-3" id="clientCertificateForm">
                                    {{ Form::label('client_certificates', __('dedicated_servers.client_certificate'), ['class' => 'control-label']) }}
                                    {{ Form::select('client_certificate_id', $clientCertificates , null, ['class' => 'form-select']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap  mb-2">
            <div class="md:w-1/5 pr-4 pl-4 md:mx-2/5">
                <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600" data-bs-toggle="collapse" href="#editScripts" role="button" aria-expanded="false" aria-controls="editScripts">
                    {{ __('dedicated_servers.edit_scripts') }}
                </a>
            </div>

            <div class="md:w-full pr-4 pl-4">
                <div class="hidden" id="editScripts">
                    <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('dedicated_servers.scripts') }}</div>
                        <div class="flex-auto p-6">
                            <div class="flex flex-wrap ">
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_install') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_reinstall') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_update') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_start') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_pause') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_unpause') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_stop') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_kill') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_restart') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_status') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_get_console') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_send_command') }}</div>

                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_delete') }}</div>
                                <div class="md:w-1/2 pr-4 pl-4">{{ Form::bsText('script_stats') }}</div>
                            </div>
                        </div>
                        <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300">
                            @include('admin.dedicated_servers.shortcodes_description')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('dedicated_servers.create') }}
            </g-button>
        </div>

    {!! Form::close() !!}
@endsection

