@php($title = "Edit Server")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.servers.index') }}">Servers</a></li>
        <li>Edit server</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers.update', $server->id], 'id' => 'adminServerForm']) !!}
    <div class="col-md-6">
        {{ Form::bsText('name') }}
        {{ Form::bsText('code_name') }}

        <div class="form-group" id="dedicatedServerForm">
            {{ Form::label('ds_id', 'Dedicated server', ['class' => 'control-label']) }}
            {{ Form::select('ds_id', $dedicatedServers, null, ['class' => 'form-control', 'v-on:change' => 'dsChangeHandler', 'v-model' => 'dsId']) }}
        </div>

        <div class="form-group">
            <template id="ip-list-template">
                {{ Form::label('server_ip', 'IP', ['class' => 'control-label']) }}

                <select class='form-control' id='server_ip' name='server_ip'>
                    <option :value="ip" v-for="ip in ipList">@{{ip}}</option>
                </select>
            </template>
        </div>

        {{ Form::bsText('server_port') }}

        {{--{{ Form::bsText('query_port') }}--}}
        {{--{{ Form::bsText('rcon_port') }}--}}

        <div class="form-group">
            {{ Form::label('game_id', 'Game', ['class' => 'control-label']) }}
            {{ Form::select('game_id', $games, null, ['class' => 'form-control']) }}
        </div>

        {{--TODO: Autoload games mods for selected games--}}
        <div class="form-group">
        {{ Form::label('game_mod_id', 'Game Mod', ['class' => 'control-label']) }}
        {{ Form::select('game_mod_id', [], null, ['class' => 'form-control']) }}
        </div>

        {{ Form::bsText('rcon') }}
        {{ Form::bsText('dir') }}
        {{ Form::bsText('su_user') }}
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('footer-scripts')
    <script src="{{ URL::asset('/js/adminServerForm.js') }}"></script>
@endsection