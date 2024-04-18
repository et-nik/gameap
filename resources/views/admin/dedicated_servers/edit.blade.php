@php($title = __('dedicated_servers.title_edit'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.dedicated_servers.index") }}', 'text':'{{ __("dedicated_servers.dedicated_servers") }}'},
        {'text':'{{ __("dedicated_servers.edit") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active" data-bs-toggle="tab" href="#main">{{ __('dedicated_servers.main') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#scripts">{{ __('dedicated_servers.scripts') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#gdaemon">GDaemon</a>
        </li>
    </ul>

    {!! Form::model($dedicatedServer, [
        'method' => 'PATCH',
        'route' => ['admin.dedicated_servers.update', $dedicatedServer->id],
        'files' => true
    ]) !!}

        <div class="tab-content">
            <div class="tab-pane active" id="main">
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
                                {{ __('dedicated_servers.ip_list') }}
                            </div>
                            <div class="flex-auto p-6">
                                <input-text-list :initial-items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane opacity-0" id="scripts">
                <div class="flex flex-wrap ">
                    <div class="md:w-full pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
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

            <div class="tab-pane opacity-0" id="gdaemon">
                <div class="flex flex-wrap ">
                    <div class="md:w-full pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                            <div class="flex-auto p-6">
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
                                            {{ Form::label('gdaemon_server_cert', __('dedicated_servers.change_certificate'), ['class' => 'input-group-text']) }}

                                            @if ($errors->has('gdaemon_server_cert'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('gdaemon_server_cert') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap ">
                                    <div class="md:w-1/2 pr-4 pl-4">
                                        <div class="mb-3" id="clientCertificateForm">
                                            {{ Form::label('client_certificates', __('dedicated_servers.client_certificate'), ['class' => 'control-label']) }}
                                            {{ Form::select('client_certificate_id', $clientCertificates , $dedicatedServer->client_certificate_id, ['class' => 'form-select']) }}
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap ">
            <div class="md:w-full pr-4 pl-4">
                <div class="mb-3">
                    {{ Form::submit(__('dedicated_servers.save'), ['class' => 'btn btn-success btn-ico btn-ico-save']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection
