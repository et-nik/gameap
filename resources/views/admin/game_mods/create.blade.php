@php($title = __('games.title_add_mod'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
            @if($game)
                {'link':'{{ route("admin.games.edit", ["game" => $game]) }}', 'text':'{{ $gameList[$game] }}'},
            @endif
        {'text':'{{ __("games.add_mod") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.game_mods.index')]) !!}
        <div class="flex flex-wrap  mt-2 mb-2">
            <div class="md:w-full pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">
                        <div class="mb-3" id="dedicatedServerForm">
                            {{ Form::label('game_code', __('games.game'), ['class' => 'control-label']) }}
                            {{ Form::select('game_code', $gameList, $game, ['class' => 'form-select']) }}
                        </div>

                        {{ Form::bsText('name') }}
                        {{ Form::bsText('remote_repository_linux') }}
                        {{ Form::bsText('remote_repository_windows') }}
                        {{ Form::bsText('local_repository_linux') }}
                        {{ Form::bsText('local_repository_windows') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full pr-4 pl-4">
            <div class="mb-3">
                {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
            </div>
        </div>

    {!! Form::close() !!}
@endsection
