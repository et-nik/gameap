@php($title = __('games.title_edit_mod'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">{{ __('games.games') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.edit', ['game' => $gameMod->game->code]) }}">{{ $gameMod->game->name }}</a></li>
        <li class="breadcrumb-item active">{{  __('games.title_edit_mod') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#main">{{ __('games.main') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#game-servers-commands">{{ __('games.servers_commands') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#vars">{{ __('games.vars') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fast-rcon">{{ __('games.fast_rcon_commands') }}</a>
        </li>
    </ul>

    {!! Form::model($gameMod, ['method' => 'PATCH','route' => ['admin.game_mods.update', $gameMod->id]]) !!}
    <div class="tab-content">
        <div class="tab-pane container-fluid active" id="main">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            {{ __('games.basic_info') }}
                        </div>
                        <div class="card-body">
                            {{ Form::bsText('name') }}
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header">
                            {{ __('games.run_commands') }}
                        </div>
                        <div class="card-body">
                            {{ Form::bsText('default_start_cmd_linux') }}
                        </div>
                        <div class="card-body">
                            {{ Form::bsText('default_start_cmd_windows') }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            {{ __('games.repositories') }}
                        </div>
                        <div class="card-body">
                            {{ Form::bsText('remote_repository') }}
                            {{ Form::bsText('local_repository') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container-fluid fade" id="game-servers-commands">
            <div class="row mt-2">
                <div class="col-12 m-2">
                    <div class="card">
                        <div class="card-header">
                            {{ __('games.servers_commands') }}
                        </div>
                        <div class="card-body">

                            {{ Form::bsInput('text', [
                                'name' => 'kick_cmd',
                                'description' => __('games.d_kick_cmd')
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'ban_cmd',
                                'description' => __('games.d_ban_cmd')
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'chname_cmd',
                                'description' => __('games.d_chname_cmd')
                            ]) }}

                            {{ Form::bsText('srestart_cmd') }}

                            {{ Form::bsInput('text', [
                                'name' => 'chmap_cmd',
                                'description' => __('games.d_chmap_cmd')
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'sendmsg_cmd',
                                'description' => __('games.d_sendmsg_cmd')
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'passwd_cmd',
                                'description' => __('games.d_passwd_cmd')
                            ]) }}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container-fluid fade" id="vars">
            <div class="row mt-2 mb-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <input-many-list
                                    name="vars"
                                    :initial-items="{{ json_encode($gameMod->vars) }}"
                                    :labels="{{ json_encode([__('games.var'), __('games.default'), __('games.info'), __('games.admin_var')]) }}"
                                    :keys="{{ json_encode(['var', 'default', 'info', 'admin_var']) }}"
                                    :input-types="{{ json_encode(['text', 'text', 'text', 'checkbox']) }}">
                            </input-many-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container-fluid fade" id="fast-rcon">
            <div class="row mt-2 mb-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <input-many-list
                                    name="fast_rcon"
                                    :initial-items="{{ json_encode($gameMod->fast_rcon) }}"
                                    :labels="{{ json_encode([__('games.description'), __('games.rcon_command')]) }}"
                                    :keys="{{ json_encode(['info', 'command']) }}"
                                    :input-types="{{ json_encode(['text', 'text']) }}">
                            </input-many-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
    {!! Form::close() !!}
@endsection
