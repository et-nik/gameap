@php($title = 'Game server settings')

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.servers.index") }}', 'text':'{{ __("servers.game_servers") }}'},
        {'link':'{{ route("admin.servers.edit", ["server" => $server->id]) }}', 'text':'{{ $server->name }}'},
        {'text':'{{ __("servers.settings") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <div>
        {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers_settings.update', $server->id]]) !!}
        <div class="flex flex-wrap ">
            <div class="w-full">
                <settings-parameters
                        :initial-items="{{ $settings->toJson() }}"
                        input-name="settings">
                </settings-parameters>
            </div>

            <div class="w-full">
                <div class="mb-3">
                    {{ Form::submit(__('main.save'), ['class' => 'btn btn-success btn-ico btn-ico-save']) }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
