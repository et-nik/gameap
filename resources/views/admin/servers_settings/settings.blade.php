@php($title = 'Game server settings')

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.servers.index') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">{{ $server->name }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('servers.settings') }}</li>
    </ol>
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
