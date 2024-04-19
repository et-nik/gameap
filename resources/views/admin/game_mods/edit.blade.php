@php($title = __('games.title_edit_mod'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
        {'link':'{{ route("admin.games.edit", ["game" => $gameMod->game->code]) }}', 'text':'{{ $gameMod->game->name }}'},
        {'text':'{{ __("games.title_edit_mod") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active" data-bs-toggle="tab" href="#main">{{ __('games.main') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#game-servers-commands">{{ __('games.servers_commands') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#vars">{{ __('games.vars') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#fast-rcon">{{ __('games.fast_rcon_commands') }}</a>
        </li>
    </ul>

    {!! Form::model($gameMod, ['method' => 'PATCH','route' => ['admin.game_mods.update', $gameMod->id]]) !!}
        <div class="tab-content">
            <div class="tab-pane active" id="main">
                <div class="flex flex-wrap  mt-2">
                    <div class="md:w-1/2 pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                                {{ __('games.basic_info') }}
                            </div>
                            <div class="flex-auto p-6">
                                {{ Form::bsText('name') }}
                            </div>
                        </div>

                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mt-2">
                            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                                {{ __('games.run_commands') }}
                            </div>
                            <div class="flex-auto p-6">
                                {{ Form::bsText('start_cmd_linux') }}
                                {{ Form::bsText('start_cmd_windows') }}
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/2 pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
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
            </div>

            <div class="tab-pane opacity-0" id="game-servers-commands">
                <div class="flex flex-wrap  mt-2">
                    <div class="md:w-full pr-4 pl-4 m-2">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                                {{ __('games.servers_commands') }}
                            </div>
                            <div class="flex-auto p-6">

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

            <div class="tab-pane opacity-0" id="vars">
                <div class="flex flex-wrap  mt-2 mb-2">
                    <div class="md:w-full pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                            <div class="flex-auto p-6">
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

            <div class="tab-pane opacity-0" id="fast-rcon">
                <div class="flex flex-wrap  mt-2 mb-2">
                    <div class="md:w-full pr-4 pl-4">
                        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                            <div class="flex-auto p-6">
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

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('main.save') }}
            </g-button>
        </div>

    {!! Form::close() !!}
@endsection
