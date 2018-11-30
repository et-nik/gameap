@php($title = "Edit Game Mod")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Games</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.edit', ['game' => $gameMod->game->code]) }}">{{ $gameMod->game->name }}</a></li>
        <li class="breadcrumb-item active">Edit Game Mod</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#game-servers-commands">Game Servers Commands</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#vars">Vars</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fast-rcon">Fast RCON commands</a>
        </li>
    </ul>

    {!! Form::model($gameMod, ['method' => 'PATCH','route' => ['admin.game_mods.update', $gameMod->id]]) !!}
    <div class="tab-content">
        <div class="tab-pane container-fluid active" id="main">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Basic Info
                        </div>
                        <div class="card-body">
                            {{ Form::bsText('name') }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Repositories
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
                            Game Server Commands
                        </div>
                        <div class="card-body">

                            {{ Form::bsInput('text', [
                                'name' => 'kick_cmd',
                                'description' => 'Shortcodes: {id} -- player id, {name} -- player name'
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'ban_cmd',
                                'description' => 'Shortcodes: {id} -- player id, {name} -- player name, {time} -- time, {reason}'
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'chname_cmd',
                                'description' => 'Shortcodes: {id} -- player id, {name} -- player name, {time} -- time, {reason}'
                            ]) }}

                            {{ Form::bsText('srestart_cmd') }}

                            {{ Form::bsInput('text', [
                                'name' => 'chmap_cmd',
                                'description' => 'Shortcodes: {map}'
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'sendmsg_cmd',
                                'description' => 'Shortcodes: {msg} -- message'
                            ]) }}

                            {{ Form::bsInput('text', [
                                'name' => 'passwd_cmd',
                                'description' => 'Shortcodes: {password}'
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
                            {{-- TODO: Replace keys --}}
                            <input-many-list
                                    name="vars"
                                    :initial-items="{{ json_encode($gameMod->vars) }}"
                                    :labels="{{ json_encode(['Var', 'Default', 'Info', 'Only Admins']) }}"
                                    :keys="{{ json_encode(['alias', 'default_value', 'desc', 'only_admins']) }}"
                                    {{--:keys="{{ json_encode(['var', 'default', 'info', 'only_admins']) }}">--}}
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
                                    :labels="{{ json_encode(['Description', 'RCON Command']) }}"
                                    :keys="{{ json_encode(['desc', 'rcon_command']) }}"
                                    :input-types="{{ json_encode(['text', 'text']) }}">
                            </input-many-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
    {!! Form::close() !!}
@endsection
