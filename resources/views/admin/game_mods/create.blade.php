@php($title = "Create Game Mod")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Games</a></li>
        @if($game)
            <li class="breadcrumb-item"><a href="{{ route('admin.games.edit', ['game' => $gameList[$game]]) }}">{{ $gameList[$game] }}</a></li>
        @endif
        <li class="breadcrumb-item active">Create Mod</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.game_mods.index')]) !!}
        <div class="col-md-6">
            <div class="form-group" id="dedicatedServerForm">
                {{ Form::label('game_code', 'Game', ['class' => 'control-label']) }}
                {{ Form::select('game_code', $gameList, $game, ['class' => 'form-control']) }}
            </div>

            {{ Form::bsText('name') }}
            {{ Form::bsText('remote_repository') }}
            {{ Form::bsText('local_repository') }}
        </div>

    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection
