@php($title = __('games.title_edit'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
        {'text':'{{ __("games.title_edit") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-large bg-lime-500 text-white hover:bg-lime-600" href="{{ route('admin.game_mods.create', ['game' => $game->code]) }}">
            <span class="fa fa-cat"></span>&nbsp;{{ __('games.add_mod') }}
        </a>
    </div>

    {!! Form::model($game, ['method' => 'PATCH','route' => ['admin.games.update', $game->code]]) !!}

        <div class="flex flex-wrap  mt-2 mb-2">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('games.basic_info') }}
                    </div>
                    <div class="flex-auto p-6">
                        {{ Form::bsText('code', null, null, ['disabled']) }}
                        {{ Form::bsText('name') }}

                        {{ Form::bsText('engine') }}
                        {{ Form::bsText('engine_version') }}
                    </div>
                </div>

                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-2">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('games.mods') }}
                    </div>
                    <div class="flex-auto p-6">
                        <ul class="flex flex-col pl-0 mb-0 border rounded border-gray-300 ">
                            @foreach ($game->mods as $mod)
                                <li class="relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-gray-300 no-underline"><a href="{{ route('admin.game_mods.edit', ['game_mod' => $mod->id]) }}">{{ $mod->name }}</a></li>
                            @endforeach
                        </ul>
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

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('main.save') }}
            </g-button>
        </div>

    {!! Form::close() !!}
@endsection
