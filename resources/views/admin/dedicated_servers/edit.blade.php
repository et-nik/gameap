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

    {!! Form::model($dedicatedServer, [
        'method' => 'PATCH',
        'route' => ['admin.dedicated_servers.update', $dedicatedServer->id],
        'files' => true
    ]) !!}
        <n-tabs type="line" class="flex justify-between" animated>
            <n-tab-pane name="main">
                <template #tab>
                    {{ __('dedicated_servers.main') }}
                </template>

                <div class="flex flex-wrap">
                    <div class="md:w-1/2 pr-8">
                        <n-card
                                class="mb-3"
                                header-class="bg-stone-100"
                                :segmented="{
                              content: true,
                              footer: 'soft'
                            }"
                        >
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
                        </n-card>
                    </div>

                    <div class="md:w-1/2">
                        <n-card
                                title="{{ __('dedicated_servers.ip_list') }}"
                                class="mb-3"
                                header-class="bg-stone-100"
                                :segmented="{
                              content: true,
                              footer: 'soft'
                            }"
                        >
                            <input-text-list :initial-items="{{ json_encode($dedicatedServer->ip) }}" name="ip" label="IP"></input-text-list>
                        </n-card>
                    </div>
                </div>
            </n-tab-pane>

            <n-tab-pane name="scripts">
                <template #tab>
                    {{ __('dedicated_servers.scripts') }}
                </template>

                <div class="flex flex-wrap ">
                    <div class="md:w-full">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-3 mb-3">
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
            </n-tab-pane>

            <n-tab-pane name="daemon">
                <template #tab>
                    Daemon
                </template>

                <div class="flex flex-wrap ">
                    <div class="md:w-full">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-3 mb-3">
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
            </n-tab-pane>
        </n-tabs>

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('dedicated_servers.save') }}
            </g-button>
        </div>

    {!! Form::close() !!}
@endsection
