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

            <div class="md:w-full mt-4 mb-8">
                <g-button color="green">
                    <i class="fas fa-save"></i></i>&nbsp;{{ __('main.save') }}
                </g-button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
