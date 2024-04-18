@php($title = __('games.title_add'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
        {'text':'{{ __("games.add") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.games.index')]) !!}
        <div class="flex flex-wrap  mt-2 mb-2">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">
                            {{ Form::bsText('code') }}
                            {{ Form::bsText('name') }}
                            {{ Form::bsText('engine') }}
                            {{ Form::bsText('engine_version') }}
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('games.steam_info') }}
                    </div>
                    <div class="flex-auto p-6">
                        {{ Form::bsText('steam_app_id_linux') }}
                        {{ Form::bsText('steam_app_id_windows') }}
                        {{ Form::bsText('steam_app_set_config') }}
                    </div>
                </div>

                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-2">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('games.repositories_local') }}
                    </div>
                    <div class="flex-auto p-6">
                        {{ Form::bsText('local_repository_linux') }}
                        {{ Form::bsText('local_repository_windows') }}
                    </div>
                </div>

                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-2">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('games.repositories_remote') }}
                    </div>
                    <div class="flex-auto p-6">
                        {{ Form::bsText('remote_repository_linux') }}
                        {{ Form::bsText('remote_repository_windows') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full pr-4 pl-4 mt-4">
            <div class="mb-3">
                {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
