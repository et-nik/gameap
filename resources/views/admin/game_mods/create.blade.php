@php($title = __('games.title_add_mod'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">{{ __('games.games') }}</a></li>
        @if($game)
            <li class="breadcrumb-item"><a href="{{ route('admin.games.edit', ['game' => $gameList[$game]]) }}">{{ $gameList[$game] }}</a></li>
        @endif
        <li class="breadcrumb-item active">{{ __('games.add_mod') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.game_mods.index')]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group" id="dedicatedServerForm">
                            {{ Form::label('game_code', __('games.game'), ['class' => 'control-label']) }}
                            {{ Form::select('game_code', $gameList, $game, ['class' => 'form-control']) }}
                        </div>

                        {{ Form::bsText('name') }}
                        {{ Form::bsText('remote_repository') }}
                        {{ Form::bsText('local_repository') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
            </div>
        </div>

    {!! Form::close() !!}
@endsection
