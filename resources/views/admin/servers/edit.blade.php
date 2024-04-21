@php
/**
 * @var $server \Gameap\Models\Server
*/
@endphp

@php($title = __('servers.title_edit'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.servers.index") }}', 'text':'{{ __("servers.game_servers") }}'},
        {'text':'{{ __("servers.edit") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-large bg-gray-100 text-gray-800 hover:bg-gray-200" href="{{ route('admin.servers_settings.edit', ['server' => $server->id]) }}">
            <span class="fa fa-cogs"></span>&nbsp;{{ __('servers.settings') }}
        </a>&nbsp;

        <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-large bg-gray-100 text-gray-800 hover:bg-gray-200" href="{{ route('servers.control', ['server' => $server->id]) }}">
            <span class="fa fa-chalkboard"></span>&nbsp;{{ __('servers.control') }}
        </a>
    </div>


    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers.update', $server->id], 'id' => 'adminServerForm']) !!}
        <div class="flex flex-wrap mt-2">
            <div class="md:w-1/2 pr-8">
                <n-card
                        title="{{ __('servers.basic_info') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
                >
                        <div class="mb-3 mt-4">
                            <div class="flex flex-wrap ">
                                <div class="md:w-1/4 pr-4 pl-4">
                                    <div class="relative block mb-2">
                                        {{ Form::checkbox('enabled', 'on', null, ['id' => 'enabled', 'class' => 'form-check-input']) }}
                                        {{ Form::label('enabled', __('labels.enabled'), ['class' => 'form-check-label']) }}
                                    </div>
                                </div>

                                <div class="md:w-1/4 pr-4 pl-4">
                                    <div class="relative block mb-2">
                                        {{ Form::checkbox('blocked', 'on', null, ['id' => 'blocked', 'class' => 'form-check-input']) }}
                                        {{ Form::label('blocked', __('labels.blocked'), ['class' => 'form-check-label']) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{ Form::bsText('uuid', null, null, ['disabled' => 'disabled']) }}
                        {{ Form::bsText('name') }}

                        <div class="mb-3" id="installed">
                            {{ Form::label('installed', __('servers.status'), ['class' => 'control-label']) }}
                            {{ Form::select('installed', [
                                    $server::NOT_INSTALLED        => ucfirst(__('servers.not_installed')),
                                    $server::INSTALLED            => ucfirst(__('servers.installed')),
                                    $server::INSTALLATION_PROCESS => ucfirst(__('servers.installation')),
                                ], $server->installed, ['class' => 'form-select'])
                            }}
                        </div>

                        <game-mod-selector
                                :games="{{ $games }}"
                                initial-game="{{ $server->game_id }}"
                                initial-mod="{{ $server->game_mod_id }}">
                        </game-mod-selector>

                        <div class="mb-3{{ $errors->has('rcon') ? ' has-error' : '' }}">
                            {{ Form::label('rcon', null, ['class' => 'control-label']) }}

                            <div class="relative flex items-stretch w-full">
                                {{ Form::input('password', 'rcon', $server->rcon,
                                    ['class' => 'form-control password', 'autocomplete' => 'new-password']) }}
                                <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline text-gray-600 border-gray-600 hover:bg-gray-600 hover:text-white bg-white hover:bg-gray-700 show-hide-password" type="button"><i class="far fa-eye"></i></button>
                            </div>

                        </div>

                        {{ Form::bsInput('text', [
                            'name' => 'dir',
                            'description' => __('servers.d_dir')
                        ]) }}

                        {{ Form::bsText('su_user') }}
                </n-card>
            </div>

            <div class="md:w-1/2">
                <n-card
                        title="{{ __('servers.ds_ip_ports') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
                >
                    <ds-ip-selector
                            :ds-list="{{ $dedicatedServers }}"
                            :initial-ds-id="{{ $server->ds_id }}"
                            initial-ip="{{ $server->server_ip }}">
                    </ds-ip-selector>

                    <smart-port-selector
                            initial-server-ip="{{ $server->server_ip }}"
                            initial-server-port="{{ $server->server_port }}"
                            initial-query-port="{{ $server->query_port }}"
                            initial-rcon-port="{{ $server->rcon_port }}">
                    </smart-port-selector>
                </n-card>
            </div>
        </div>

        <div class="flex flex-wrap mt-2">
            <div class="md:w-full">
                <n-card
                        title="{{ __('servers.start_command') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
                >
                    {{ Form::bsTextArea('start_command', null, null, ['rows' => 3]) }}

                    <div class="md:w-full">
                        <table class="stone-table">
                            <thead class="stone-table-header">
                                <tr>
                                    <th class="px-2 py-2">{{ __('main.name') }}</th>
                                    <th class="px-2 py-2">{{ __('main.value') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($server->aliases as $aliasName => $aliasValue)
                                <tr class="stone-table-row">
                                    <td class="px-2 py-2">
                                        <code class="bg-gray-100 highlighter-rouge p-1 rounded">
                                            <span>{</span>{{ $aliasName }}<span>}</span>
                                        </code>
                                    </td>
                                    <td class="px-2 py-2">{{ $aliasValue }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </n-card>
            </div>
        </div>

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('main.save') }}
            </g-button>
        </div>

    {!! Form::close() !!}
@endsection

@section('footer-scripts')
    @include('scripts.formHelper')
@endsection
