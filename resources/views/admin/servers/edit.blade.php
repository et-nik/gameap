@php
/**
 * @var $server \Gameap\Models\Server
 *
*/
@endphp

@php($title = __('servers.title_edit'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('servers.edit') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="btn btn-large btn-light" href="{{ route('admin.servers_settings.edit', ['server' => $server->id]) }}">
            <span class="fa fa-cogs"></span>&nbsp;{{ __('servers.settings') }}
        </a>

        <a class="btn btn-large btn-light" href="{{ route('servers.control', ['server' => $server->id]) }}">
            <span class="fa fa-chalkboard"></span>&nbsp;{{ __('servers.control') }}
        </a>
    </div>


    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers.update', $server->id], 'id' => 'adminServerForm']) !!}
        <div class="row mt-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('servers.basic_info') }}
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group mt-4 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-check">
                                        {{ Form::checkbox('enabled', 'on', null, ['id' => 'enabled', 'class' => 'form-check-input']) }}
                                        {{ Form::label('enabled', __('labels.enabled'), ['class' => 'form-check-label']) }}
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-check">
                                        {{ Form::checkbox('blocked', 'on', null, ['id' => 'blocked', 'class' => 'form-check-input']) }}
                                        {{ Form::label('blocked', __('labels.blocked'), ['class' => 'form-check-label']) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{ Form::bsText('uuid', null, null, ['disabled' => 'disabled']) }}
                        {{ Form::bsText('name') }}

                        <div class="form-group" id="installed">
                            {{ Form::label('installed', __('servers.status'), ['class' => 'control-label']) }}
                            {{ Form::select('installed', [
                                    $server::NOT_INSTALLED        => ucfirst(__('servers.not_installed')),
                                    $server::INSTALLED            => ucfirst(__('servers.installed')),
                                    $server::INSTALLATION_PROCESS => ucfirst(__('servers.installation')),
                                ], $server->installed, ['class' => 'form-control'])
                            }}
                        </div>

                        <game-mod-selector
                                :games="{{ $games }}"
                                initial-game="{{ $server->game_id }}"
                                initial-mod="{{ $server->game_mod_id }}">
                        </game-mod-selector>

                        <div class="form-group{{ $errors->has('rcon') ? ' has-error' : '' }}">
                            {{ Form::label('rcon', null, ['class' => 'control-label']) }}

                            <div class="input-group">
                                {{ Form::input('password', 'rcon', $server->rcon,
                                    ['class' => 'form-control password', 'autocomplete' => 'new-password']) }}

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary show-hide-password" type="button"><i class="far fa-eye"></i></button>
                                </div>
                            </div>

                        </div>

                        {{ Form::bsInput('text', [
                            'name' => 'dir',
                            'description' => __('servers.d_dir')
                        ]) }}

                        {{ Form::bsText('su_user') }}
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('servers.ds_ip_ports') }}
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card mt-2">
                    <div class="card-header">
                        {{ __('servers.start_command') }}
                    </div>
                    <div class="card-body">
                        {{ Form::bsTextArea('start_command', null, null, ['rows' => 3]) }}

                        <div class="col-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ __('main.name') }}</th>
                                    <th>{{ __('main.value') }}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($server->aliases as $aliasName => $aliasValue)
                                    <tr>
                                        <td>
                                            <code class="bg-light highlighter-rouge p-1 rounded">
                                                <span>{</span>{{ $aliasName }}<span>}</span>
                                            </code>

                                        </td>
                                        <td>{{ $aliasValue }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection

@section('footer-scripts')
    <script src="{{ URL::asset('/js/formHelpers.js') }}"></script>
@endsection
