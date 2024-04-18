@php($title = __('games.title_add_mod'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.games.index') }}">{{ __('games.games') }}</a></li>
        @if($game)
            <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.games.edit', ['game' => $gameList[$game]]) }}">{{ $gameList[$game] }}</a></li>
        @endif
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('games.add_mod') }}</li>
    </ol>
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
